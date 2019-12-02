![alt text](https://github.com/hxtree/PXP/raw/master/docs/logo/179x100.jpg "PXP")

***PXP transforms markup into modular code and returns rendered markup.*** It works like a templating engine, but instead 
of strictly replacing values it instantiate defines elements. Thereby, extending back end features to front end 
developers. Finally, an empowered web team.

# Quick start

Install with Composer:
>`composer require hxtree/pxp`

# Overview
Front End
```XML
<body>
	<condition toggle="signed_in">
	<h2>Welcome, <var name="first_name"/></h2>
	<block name="Messages" limit="5"/>
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

# Docs
[How It Works](https://github.com/hxtree/PXP/blob/master/docs/How%20It%20Works.md)
