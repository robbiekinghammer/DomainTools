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

namespace DomainTools;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use DomainTools\Library\Rank,
    DomainTools\Library\Servers,
    DomainTools\Library\Whois;


/**
 * --------------------------------------------------------------------------
 * DomainTools class
 * --------------------------------------------------------------------------
 * 
 * The main library.
 *
 * @package  domaintools
 * @version  1.0
 */
class DomainTools
{
    /**
     * --------------------------------------------------------------------------
     * Function: whois()
     * --------------------------------------------------------------------------
     *
     * Executes an whois on the passed domain.
     *
     * @access    public
     * @param     string
     * @return    object
     */
    public static function whois($domain = null)
    {
        // Clean the domain.
        //
        $domain = self::clean_domain($domain);

        // Return the Whois object.
        //
        return new Whois($domain);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: rank()
     * --------------------------------------------------------------------------
     *
     * Checks the rank of the passed domain.
     *
     * @access    public
     * @param     string
     * @return    object
     */
    public static function rank($domain = null)
    {
        // Clean the domain.
        //
        $domain = self::clean_domain($domain);

        // Return the Rank object.
        //
        return new Rank($domain);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: servers()
     * --------------------------------------------------------------------------
     *
     * Initiate our Server class, so we can get the servers list.
     *
     * @access    public
     * @return    object
     */
    public static function servers()
    {
        // Return the Servers object.
        //
        return new Servers();
    }


    /**
     * --------------------------------------------------------------------------
     * Function: clean_domain()
     * --------------------------------------------------------------------------
     *
     * Removes unnecessary garbage from a domain.
     *
     * @access    protected
     * @param     string
     * @return    string
     */
    protected static function clean_domain($domain)
    {
        // Remove www.
        //
        $domain = str_replace('www.', '', $domain);

        // Remove both http:// and https://
        //
        $domain = preg_replace('#^https?://#', '', $domain);
        
        // Return the cleaned domain.
        //
        return $domain;
    }
}
