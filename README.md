![alt text](https://github.com/hxtree/PXP/raw/master/docs/logo/179x100.jpg "PXP")

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/hxtree)

***PXP empower the front end team by turning markup into modular objects.*** It works like a templating engine, but
isn't limited to replacing values. PXP finds elements, instantiate them as objects, orchestrates method calls to 
objects, and then replaces the element's value.

# Installation

## Via Composer
PXP is available on [Packagist](https://packagist.org/packages/hxtree/pxp).

Install with Composer:
```shell script
$ composer require hxtree/pxp
```

# Overview
Front End
```XML
<body>
	<condition toggle="signed_in">
	<h2>Welcome, <var name="first_name"/></h2>
	<block name="Messages" limit="5">
	</condtion>
</body>
```

Back End
```php
<?php

namespace Block;

class Messages extends \Pxp\DynamicElement\DynamicElement
{
	public function view(){
		return <<<HTML
	<div class="messages">
		<p>You have no new messages</p>
	</div>
HTML;
	}
}
```

Web Browser
```HTML
<body class="page">
	<h2>Welcome, Jane</h2>
	<div class="messages">
		<p>You have no new messages.</p>
	</div>
</body>
```

# Documentation
For more detailed information check our online documentation at [pxp.readthedocs.io](pxp.readthedocs.io)

[![Documentation Status](https://readthedocs.org/projects/pxp/badge/?version=latest)](https://pxp.readthedocs.io/en/latest/?badge=latest)