<?php namespace LaraWhois;

/**
 * --------------------------------------------------------------------------
 * Lara Whois
 * --------------------------------------------------------------------------
 * 
 * A Domain whois bundle for use with the Laravel Framework.
 *
 * @package  lara-whois
 * @version  1.0
 * @author   Bruno Gaspar <brunofgaspar@live.com.pt>
 * @link     https://github.com/bruno-g/lara-whois
 */
class Whois
{
    /**
     * Whois servers list.
     *
     * @access   protected
     * @var      array
     */
    static protected $servers = array();

    /**
     * Stores the Second Level Domain, of the checked domain.
     *
     * @access   public
     * @var      string
     */
    static public $sld;

    /**
     * Stores the Top Level Domain, of the checked domain.
     *
     * @access   public
     * @var      string
     */
    static public $tld;


    /**
     * --------------------------------------------------------------------------
     * Function: init()
     * --------------------------------------------------------------------------
     *
     * Whois initializer.
     *
     * @access    public
     * @return    void
     */
    static public function init()
    {
        // Load servers list.
        //
        static::$servers = static::servers();
    }


    /**
     * --------------------------------------------------------------------------
     * Function: check()
     * --------------------------------------------------------------------------
     *
     * Check if a domain is valid and if is available.
     *
     * @access    public
     * @param     string
     * @return    array
     */
    static public function check( $domain = null )
    {
        // Separate both Second Level Domain ( SLD ) and the Top Level Domain ( TLD ).
        //
        $split = explode('.', $domain, 2);
        static::$sld = ( isset( $split[0] ) ? $split[0] : '' );
        static::$tld = ( isset( $split[1] ) ? $split[1] : '' );

        // Check if domain is valid.
        //
        if ( count($split) == 1 and ! preg_match( "/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i", $domain ) ):
            throw new \Exception( \Lang::line('lara-whois::whois.error') );

        // Check if the Top Level Domain is valid.
        //
        elseif ( count($split) == 2 and ! array_key_exists( static::$tld, static::$servers ) ):
            throw new \Exception( \Lang::line('lara-whois::whois.invalid_tld', array('tld' => static::$tld)) );

        // Check domain.
        //
        else:
            return static::whois( $domain, static::$tld );
        endif;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_tlds()
     * --------------------------------------------------------------------------
     *
     * Returns a list of Top Level Domains of a specific section.
     *
     * @access    public
     * @param     string
     * @return    array
     */
    static public function get_tlds( $section = null )
    {
        // Initiate an empty array.
        //
        $tlds = array();

        // Loop through the sections.
        //
        foreach( parse_ini_file( __DIR__ . DS . 'servers.ini', 'true' ) as $_section => $_tlds ):
            // Check if this is the section we want to check.
            //
            if ( $_section === $section ):
                // Spin trough the servers list and save them to the array.
                //
                foreach( $_tlds as $tld => $value ):
                    $value = explode('|', $value);
                    $tlds[ $tld ] = $tld;
                endforeach;
            endif;
        endforeach;

        // Return the tlds.
        //
        return $tlds;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: servers()
     * --------------------------------------------------------------------------
     *
     * Returns the whois servers list.
     *
     * @access    private
     * @return    array
     */
    static private function servers()
    {
        // Create the servers array.
        //
        $servers = array();

        // Spin trough the servers list and save them to the array.
        //
        foreach( parse_ini_file( __DIR__ . DS . 'servers.ini' ) as $tld => $value ):
            $value = explode('|', $value);
            $servers[ $tld ] = array(
                'server' => trim( strip_tags( $value[0] ) ), 
                'return' => trim( strip_tags( $value[1] ) )
            );
        endforeach;

        // Return the servers.
        //
        return $servers;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: whois()
     * --------------------------------------------------------------------------
     *
     * This function does the whois check for the desired domain.
     *
     * @access    private
     * @param     string
     * @param     string
     * @return    array
     */
    static private function whois( $domain = null, $tld = null )
    {
        // Get the needed data.
        //
        $server = static::$servers[ $tld ]['server'];
        $return = static::$servers[ $tld ]['return'];

        // Initiate an empty array.
        //
        $result = array();

        if (substr ($return, 0, 12) == 'HTTPREQUEST-'):
            $ch = curl_init();
            $url = $server . $domain;
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec ($ch);
            curl_close ($ch);
            $data2 = ' ---' . $data;
            
            // 
            //
            if ( strpos( $data2, substr($return, 12) ) == true ):
                $status = 1;
                $result['whois']  = '';
            else:
                $status = 2;
                $result['whois']  = nl2br( strip_tags( $data ) );
            endif;
        else:
            $fp = @fsockopen( $server, 43, $errno, $errstr, 10);
            if ($fp):
                $data = '';
                @fputs ($fp, $domain . "\n");
                @socket_set_timeout ($fp, 10);
                while (!@feof ($fp)):
                    $data .= @fread ($fp, 4096);
                endwhile;

                @fclose ($fp);
                $data2 = ' ---' . $data;
                if (strpos ($data2, $return) == true):
                    $status = 1;
                        $result['whois']  = '';
                else:
                    $status = 2;
                        $result['whois']  = nl2br($data);
                endif;
            else:
                $status = 0;
            endif;
        endif;

        // Append some more data.
        //
        $result['status'] = $status;
        $result['domain'] = $domain;
        $result['tld']    = $tld;

        // Return the results.
        //
        return $result;
    }
}