<?php

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


/*
 * --------------------------------------------------------------------------
 * Register some namespaces.
 * --------------------------------------------------------------------------
 */
Autoloader::namespaces(array(
    'LaraWhois' => __DIR__ . DS
));


/*
 * --------------------------------------------------------------------------
 * Set the global alias.
 * --------------------------------------------------------------------------
 */
Autoloader::alias('LaraWhois\\Whois', 'Whois');


/*
 * --------------------------------------------------------------------------
 * Initialize the Whois library.
 * --------------------------------------------------------------------------
 */
Whois::init();