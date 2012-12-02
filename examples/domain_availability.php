<?php
/*
 * In this example i'll show you how to check a domain availability.
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
    // Check the domain availability.
    //
    $availability = DomainTools::whois($domain)->availability();

    if ($availability === 0)
    {
        echo 'I was not able to check the domain, an error occured!';
    }

    elseif ($availability === 1)
    {
        echo 'Domain is available!';
    }

    else
    {
        echo 'Domain is not available!';
    }
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

    // Get the domain availability.
    //
    $availability = $whois->availability();

    if ($availability === 0)
    {
        echo 'I was not able to check the domain, an error occured!';
    }

    elseif ($availability === 1)
    {
        echo 'Domain is available!';
    }

    else
    {
        echo 'Domain is not available!';
    }
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

    // Get the domain availability.
    //
    $availability = $whois->availability();

    if ($availability === 0)
    {
        echo 'I was not able to check the domain, an error occured!';
    }

    elseif ($availability === 1)
    {
        echo 'Domain is available!';
    }

    else
    {
        echo 'Domain is not available!';
    }
}
catch (Exception $e)
{
    echo $e->getMessage();
}
