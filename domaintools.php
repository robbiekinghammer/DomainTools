<?php
/**
 * --------------------------------------------------------------------------
 * DomainTools
 * --------------------------------------------------------------------------
 *
 * Domain Tools, a bundle for use with the Laravel Framework.
 *
 * @package  Domain Tools
 * @version  2.0.0
 * @author   Bruno Gaspar <brunofgaspar1@gmail.com>
 * @link     https://github.com/bruno-g/domaintools
 */

namespace DomainTools;

/**
 * Libraries we can use.
 */
use DomainTools\Libraries\Rank;
use DomainTools\Libraries\Servers;
use DomainTools\Libraries\Whois;

/**
 * The main library.
 *
 */
class DomainTools
{
	/**
	 * Executes an whois on the passed domain.
	 *
	 * @access   public
	 * @param    string
	 * @return   object
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
	 * Checks the rank of the passed domain.
	 *
	 * @access   public
	 * @param    string
	 * @return   object
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
	 * Initiate our Server class, so we can get the servers list.
	 *
	 * @access   public
	 * @return   object
	 */
	public static function servers()
	{
		// Return the Servers object.
		//
		return new Servers();
	}

	/**
	 * Removes unnecessary garbage from a domain.
	 *
	 * @access   protected
	 * @param    string
	 * @return   string
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
