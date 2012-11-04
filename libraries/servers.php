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
use Exception;


/**
 * --------------------------------------------------------------------------
 * Servers class
 * --------------------------------------------------------------------------
 * 
 * The whois class of DomainTools.
 *
 * @package  domaintools
 * @version  1.0
 */
class Servers
{
    /**
     * Servers list.
     *
     * @access   protected
     * @var      array
     */
    protected $servers;


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
            $this->servers = $this->all();
        }

        // Return the object.
        //
        return $this;
    }



    /**
     * --------------------------------------------------------------------------
     * Function: servers()
     * --------------------------------------------------------------------------
     *
     * Returns the whois servers list.
     *
     * @access    protected
     * @return    array
     */
    public static function all()
    {
        // Initiate an empty array.
        //
        $servers = array();

        // Loop trough the servers list and save them to the array.
        //
        foreach(parse_ini_file(\Bundle::path('domaintools') . 'servers.ini') as $tld => $value)
        {
            $value = explode('|', $value);
            $servers[ $tld ] = array(
                'server' => trim(strip_tags( $value[0] )), 
                'return' => trim(strip_tags( $value[1] ))
            );
        }

        // Return the servers.
        //
        return $servers;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: tlds()
     * --------------------------------------------------------------------------
     *
     * Returns a list of Top Level Domains of a specific section.
     *
     * @access    public
     * @param     string
     * @return    array
     */
    static public function tlds( $section = null )
    {
        // Initiate an empty array.
        //
        $tlds = array();

        // Loop through the sections.
        //
        foreach(parse_ini_file(\Bundle::path('domaintools') . 'servers.ini', 'true') as $_section => $_tlds)
        {
            // Check if this is the section we want to check.
            //
            if ($_section === $section)
            {
                // Spin trough the servers list and save them to the array.
                //
                foreach($_tlds as $tld => $value)
                {
                    $value = explode('|', $value);
                    $tlds[ $tld ] = $tld;
                }
            }
        }

        // Return the tlds.
        //
        return $tlds;
    }
}
