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
 * @author   Bruno Gaspar <brunofgaspar@live.com.pt>
 * @link     https://github.com/bruno-g/domaintools
 */

namespace DomainTools\Libraries;

/**
 * Libraries we can use.
 */
use Exception;

/**
 * Servers class.
 *
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
	 * Constructor.
	 *
	 * @access   public
	 * @param    string
	 * @return   object
	 */
	public function __construct()
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
	 * Returns a list of the whois servers available.
	 *
	 * If no section is specified, we return all the whois servers.
	 *
	 * @access   public
	 * @param    string
	 * @return   array
	 */
	public static function all($section = null)
	{
		# @TODO: make the changes to use the section or not.

		// Initiate an empty array.
		//
		$servers = array();

		// Loop trough the servers list and save them to the array.
		//
		foreach(parse_ini_file(\Bundle::path('domaintools') . 'servers.ini') as $tld => $value)
		{
			$value = explode('|', $value);
			$servers[ $tld ] = array(
				'server' => trim(strip_tags($value[0])),
				'return' => trim(strip_tags($value[1]))
			);
		}

		// Return the servers.
		//
		return $servers;
	}

	/**
	 * Returns a list of Top Level Domains of a specific section.
	 *
	 * If no section is specified, we return all the tld's.
	 *
	 * @access   public
	 * @param    string
	 * @return   array
	 */
	static public function tlds($section = null)
	{
		// Initiate an empty array.
		//
		$tlds = array();

		// Section not specified? Ok, return all the tld's.
		//
		if(is_null($section))
		{
			foreach(parse_ini_file(\Bundle::path('domaintools') . 'servers.ini') as $tld => $whois_info)
			{
				$tlds[ $tld ] = $tld;
			}
		}

		// We have a section specified.
		//
		else
		{
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
		}

		// Return the tlds.
		//
		return $tlds;
	}
}
