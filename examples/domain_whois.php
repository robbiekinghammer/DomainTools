<?php
/*
 * In this example i'll show you how to get the domain whois information.
 *
 */

/*
 * ---------------------------------------------------
 * Domain we want to check for.
 * ---------------------------------------------------
 */
$domain = 'google.com';

/*
 * ---------------------------------------------------
 * Method 1
 * ---------------------------------------------------
 */
try
{
    // Execute the whois.
    //
    $whois = DomainTools::whois($domain)->info();

    // Print or do what you want with the information.
    //
    echo '<pre>';
    var_dump($whois);
    echo '</pre>';
}
catch (Exception $e)
{
    echo $e->getMessage();
}


/*
 * ---------------------------------------------------
 * Method 2
 * ---------------------------------------------------
 */
try
{
    // Execute the whois.
    //
    $whois = DomainTools::whois($domain);

    // Print or do what you want with the information.
    //
    echo '<pre>';
    var_dump($whois->info());
    echo '</pre>';
}
catch (Exception $e)
{
    echo $e->getMessage();
}


/*
 * ---------------------------------------------------
 * Method 3
 * ---------------------------------------------------
 */
try
{
    // Instantiate DomainTools
    //
    $dt = new DomainTools();

    // Execute the whois.
    //
    $whois = $dt->whois($domain);

    // Get the domain whois information.
    //
    $info = $whois->info();

    // Print or do what you want with the information.
    //
    echo '<pre>';
    var_dump($info);
    echo '</pre>';
}
catch (Exception $e)
{
    echo $e->getMessage();
}
