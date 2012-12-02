## Laravel Domain Tools
**Version: 1.1**

Domain tools is a Bundle for Laravel that can be used to get information about a domain name, like the domain availability and the domain whois information.

## Installation
Install via artisan

    php artisan bundle:install domaintools

or clone the project into **bundles/domaintools**

Then, add the following line into your bundles.php file array to auto-start the bundle.

    'domaintools' => array('auto' => true)

## Examples
Check the examples directory, for a couple of examples to see how to use the bundle.

## Statuses Codes

    0 - Error
    1 - Domain is available
    2 - Domain is registered
