## Lara Whois
**Version: 1.0**

A Domain Whois Bundle for Laravel.

## Installation
Install via artisan

    php artisan bundle:install lara-whois

or clone the project into **bundles/lara-whois**

Then, update your bundles.php to auto-start the bundle.

    return array(
        'lara-whois' => array( 'auto' => true )
    );
    
## How to make a whois on a domain

	try {
		$request = Whois::check('example-domain.com');

		$status = $request['status'];

		if ( $status === 0 ):
			echo 'I was not able to check the domain.';
		elseif ( $status === 1 ):
			echo 'Domain is available !';
		else:
			echo 'Domain is not available !';
		endif;
	}
	catch ( Exception $e ){
		echo $e->getMessage();
	}

## Example of Data returned 

    array(4) {
      ["whois"]=>
      string(0) ""
      ["status"]=>
      int(1)
      ["domain"]=>
      string(12) "example-domain.com"
      ["tld"]=>
      string(2) "com"
    }

##### The whois entry only gets populated when a domain is already registered.

## How to retrieve the list of common TLD's

    $tlds = Whois::get_tlds('common');
    
##### You can change this list by editing the servers.ini file.

## Statuses Codes

    0 - Error
    1 - Domain is available
    2 - Domain is registered
