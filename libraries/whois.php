<?php
/**
 * --------------------------------------------------------------------------
 * DomainTools
 * --------------------------------------------------------------------------
 * 
 * A Domain whois bundle for use with the Laravel Framework.
 *
 * @package  domaintools
 * @version  1.1
 * @author   Bruno Gaspar <brunofgaspar@live.com.pt>
 * @link     https://github.com/bruno-g/domaintools
 */

namespace DomainTools\Library;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use DomainTools\Library\Servers,
    Exception,
    Laravel\Lang;


/**
 * --------------------------------------------------------------------------
 * Whois class
 * --------------------------------------------------------------------------
 * 
 * The whois class of DomainTools.
 *
 * @package  domaintools
 * @version  1.0
 */
class Whois
{
    /**
     * Whois servers list.
     *
     * @access   protected
     * @var      array
     */
    protected $servers = array();

    /**
     * Holds the necessary information about a domain.
     *
     * @access   protected
     * @var      array
     */
    protected $information = array();

    /**
     * Holds the domain we are whoising for.
     *
     * @access   protected
     * @var      string
     */
    protected $domain = null;

    /**
     * Holds the domain SLD.
     *
     * @access   protected
     * @var      string
     */
    protected $sld = null;

    /**
     * Holds the domain TLD.
     *
     * @access   protected
     * @var      string
     */
    protected $tld = null;


    /**
     * --------------------------------------------------------------------------
     * Function: __construct()
     * --------------------------------------------------------------------------
     *
     * Constructor.
     *
     * @access    public
     * @param     string
     * @return    object
     */
    public function __construct($domain)
    {
        // Do we have the servers loaded?
        //
        if (empty($this->servers))
        {
            $this->servers = Servers::all();
        }

        // Make the whois search.
        //
        return $this->whois($domain);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: whois()
     * --------------------------------------------------------------------------
     *
     * Executes the whois on a domain.
     *
     * @access    protected
     * @param     string
     * @return    object
     */
    protected function whois($domain)
    {
        // Make sure we have both SLD and TLD.
        //
        if ( ! strpos($domain, '.'))
        {
            throw new Exception(Lang::line('domaintools::domaintools.invalid.domain', array('domain' => $domain)));
        }

        // Separate both Second Level Domain ( SLD ) and the Top Level Domain ( TLD ).
        //
        list($sld, $tld) = explode('.', $domain, 2);

        // Check if domain is valid.
        //
        if ( ! preg_match("/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net)|(om|org)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i", $domain))
        {
            throw new Exception(Lang::line('domaintools::domaintools.invalid.domain', array('domain' => $domain)));
        }

        // Check if the Top Level Domain is valid.
        //
        elseif ( ! array_key_exists($tld, $this->servers))
        {
            throw new Exception(Lang::line('domaintools::domaintools.invalid.tld', array('tld' => $tld)));
        }

        // Get the needed data.
        //
        $server = $this->servers[ $tld ]['server'];
        $return = $this->servers[ $tld ]['return'];

        // Fallback data.
        //
        $result = array(
            'domain' => $domain,
            'sld'    => $sld,
            'tld'    => $tld,
            'whois'  => null
        );
        $availability = 0;


        if (substr($return, 0, 12) == 'HTTPREQUEST-')
        {
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
            if (strpos($data2, substr($return, 12)) == true)
            {
                $availability = 1;
            }
            else
            {
                $availability = 2;
                $result['whois']  = nl2br(strip_tags($data));
            }
        }

        else
        {
            $fp = @fsockopen($server, 43, $errno, $errstr, 10);
            if ($fp)
            {
                $data = '';
                @fputs($fp, $domain . "\n");
                @socket_set_timeout($fp, 10);
                while ( ! @feof($fp)):
                    $data .= @fread($fp, 4096);
                endwhile;

                @fclose ($fp);
                $data2 = ' ---' . $data;
                if (strpos($data2, $return) == true)
                {
                    $availability = 1;
                }
                else
                {
                    $availability = 2;
                    $result['whois']  = nl2br($data);
                }
            }
        }

        // Append some more data.
        //
        $result['availability'] = $availability;

        // Store the needed information.
        //
        $this->information = $result;
        $this->domain      = $domain;
        $this->sld         = $sld;
        $this->tld         = $tld;

        // Return the object.
        //
        return $this;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: availability()
     * --------------------------------------------------------------------------
     *
     * Returns the domain availability status.
     *
     * @access    public
     * @return    integer
     */
    public function availability()
    {
        return $this->information['availability'];
    }
}
