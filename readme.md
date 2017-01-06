## Laravel Dinero REST wrapper

#Installation

1. Require using composer
````
composer require lasserafn/dinero-economic
````

# Usage
You could actually use this for non-Laravel projects aswell, since we do not utilize any Laravel-specific functionality (we use Illuminate collections, that is required in the composers file)
**However** I do not support anything but Laravel, so it has not been tested. Use at your own risk.

## Initializing
It's simple to get started
```` php
 $dinero = new \LasseRafn\Dinero\Dinero( $clientId, $clientSecret );
 $dinero->auth( $apiKey, $orgId );
 
 $contacts = $dinero->contacts()->perPage(10)->page(2)->get();
 
 // Do something with the contacts.
````

```` php
 $invoices = $dinero->invoices()->all();
````

```` php
 $products = $dinero->products()->deletedOnly()->all();
````