## Laravel Dinero REST wrapper
This is a PHP/Laravel wrapper for Dinero.

------

# Framework-agnostic package in the making

This package is no longer actively maintained, as I'm switching to this one: [LasseRafn/php-dinero](https://github.com/LasseRafn/php-dinero)

## Benefits of the new package include:

* Better code
* Cleaned code
* Tested code
* Fewer dependencies (removed `illuminate/support`)
* Maintained

------

You could actually use this for non-Laravel projects aswell, since we do not utilize any Laravel-specific functionality (we use Illuminate collections, that is required in the composers file)
**However** I do not support anything but Laravel, so it has not been tested. Use at your own risk.

# Installation 

1. Require using composer
````
composer require lasserafn/dinero-economic
````

# Getting started
```` php
 $dinero = new \LasseRafn\Dinero\Dinero( $clientId, $clientSecret );
 $dinero->auth( $apiKey, $orgId ); // this WILL send a request to the auth API.
 
 $contacts = $dinero->contacts()->perPage(10)->page(2)->get();
 
 // Do something with the contacts.
````

```` php
 $invoices = $dinero->invoices()->all();
````

```` php
 $products = $dinero->products()->deletedOnly()->all();
````

You can also use an old auth token, if you dont want to auth everytime you setup a new instance of Dinero.
```` php
 $dinero = new \LasseRafn\Dinero\Dinero( $clientId, $clientSecret );
 $dinero->setAuth($token, $orgId); // this will NOT send a request to the auth API.
 
 $products = $dinero->products()->deletedOnly()->all();
````

## About us / me
I created this library to make integrations with Dinero easier, considering we do **A LOT** of integrations at my work. 
I did this project while working at [Bizz Zolutions](https://bizzz.dk).
