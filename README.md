EphChartbeat
===============

A Chartbeat module for Zend Framework 2

Introduction
------------

This module will add Chartbeat tracking code to your ZF2 Application via the HeadScript and InlineScript View Helpers.

Installation
------------

First, add the following line into your `composer.json` file:

```json
"require": {
	"euphio/eph-chartbeat": ">=0.2"
}
```

Then, enable the module by adding `EphChartbeat` in your application.config.php file.

```php
<?php
return array(
	'modules' => array(
		'EphChartbeat',
		'Application',
	),
);
```

Configuration
-------------

The following settings represent the configuration variables found at: http://chartbeat.com/docs/configuration_variables/

```php
<?php
return array(
    'chartbeat' => array(
        'domain'        => 'yourdomain.com',  // Your Domain
        'no_cookies'    => false,             // Disable Cookies?
        'path'          => '',                // Path override
        'uid'           => '1234',            // Your User id
        'use_canonical' => false              // Use canonical links?
    ),
);
```