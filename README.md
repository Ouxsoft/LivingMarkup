![alt text](https://github.com/hxtree/PXP/raw/master/docs/logo/179x100.jpg "PXP")

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/hxtree)

***PXP empowers web teams by making markup magical.*** It works similar to a templating engine, but does more than 
replace values inside braces :P, it makes HTML useful. Like when you first learned HTML and thought it could do 
everything on the web? Well now it can!

# Installation

## Via Composer
PXP is available on [Packagist](https://packagist.org/packages/hxtree/pxp).

Install with Composer:
```shell script
$ composer require hxtree/pxp
```

# Overview
A PageDirector is passed a PageBuilder and parameters (containing a HTML/XML document and a list of elements to make
dynamic), it then instantiate those elements as objects using their attributes and arguments, orchestrates method calls 
to those objects (hooks), replaces the element with return value from a method call, and returns provides the parsed
document. 

Front End
```xml
<body>
	<condition toggle="signed_in">
	<h2>Welcome, <var name="first_name"/></h2>
	<block name="MessageExample" limit="5">
	    <arg name="format">list</arg>
    </block>
	</condtion>
</body>
```
MessageExample.php
```php
<?php

namespace Pxp\DynamicElement\Blocks;

class MessageExample extends \Pxp\DynamicElement\DynamicElement
{
	public function onRender(){
        switch($this->arg['format']) {
            case 'list':
                return <<<HTML
    <div class="messages">
        <p>You have no new messages</p>
    </div>
HTML;
        }
    }
}
```

Output
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