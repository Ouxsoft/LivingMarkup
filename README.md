![alt text](https://github.com/hxtree/PXP/raw/master/docs/logo/179x100.jpg "PXP")

***PXP turns markup into code.*** Allowing front and back end developers to work in harmony.

# Quick start

Install with Composer: `composer require hxtree/pxp`

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

class Messages extends \Pxp\Element
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
