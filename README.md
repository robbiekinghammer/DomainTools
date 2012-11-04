## Laravel Domain Tools
**Version: 1.1**

Domain tools is a Bundle for Laravel that can be used to get information about a domainname.

## Installation
Install via artisan

  php artisan bundle:install lara-whois

or clone the project into **bundles/domaintools**

Then, add the following line into your bundles.php file array to auto-start the bundle.

  'domaintools' => array('auto' => true)

## Examples
Check the directory examples, to see how to use the bundle.
    
## Statuses Codes

  0 - Error
  1 - Domain is available
  2 - Domain is registered
