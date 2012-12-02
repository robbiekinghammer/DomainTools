<?php
/*
 * In this example i'll show you how to get all the tld's available and the tld's of a section.
 *
 */


/*
 * ---------------------------------------------------
 * Method 1
 * ---------------------------------------------------
 */
try
{
    // Get all the tlds.
    //
    $tlds = DomainTools::servers()->tlds();

    // Print or do what you want with the information.
    //
    echo '<pre>';
    var_dump($tlds);
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
    //
    //
    $servers = DomainTools::servers();

    // Get all the tlds.
    //
    $tlds = $servers->tlds();

    // Print or do what you want with the information.
    //
    echo '<pre>';
    var_dump($tlds);
    echo '</pre>';
}
catch (Exception $e)
{
    echo $e->getMessage();
}
