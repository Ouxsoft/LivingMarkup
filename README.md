![alt text](https://github.com/hxtree/PXP/raw/master/site/assets/images/pxp/logo/179x100.jpg "PXP")

***PXP turns markup into code.*** It impowers front end designers and back end developers to work together in a way that makes sense.

Web Browser
```HTML
<body class="page">
	<h2>Welcome, Jane</h2>
	<div class="messages">
		<p>You have no new messages.</p>
	</div>
</body>
```

Server Front End (/site/pages/dashboard.)
```XML
<body>
    <condition toggle="signed_in">
		<h2>Welcome, <var name="first_name"/></h2>
		<block name="Messages" limit="5"/>
    </condtion>
</body>
```

Server Back End (/site/modules/Block/Messages.php)
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

# Guidelines for PXP Implementations

PXP by nature solves common Content Management System design flaws. But the framework 
is not limited to this implementions. Here are some guidelines for how PXP should work.

## Document / DOM
* A PXP document is either a valid XML or HTML DOM.  
* Only valid XML and HTML documents can be loaded.
* Only valid XML or HTML can be returned.
## Handlers
* Handlers are used to create dynamic elements.
* Handlers consist of two parts an XPath expressions, which is used to find the element, and a class names that is used to decide which class to instantiate the element as.
## Elements
* A element without an handler is a static element where as an element with a handler is a dyanmic element.
### Dynamic
* Allow for easy dyanmic content management
* An element's class must be autoloaded.
* Any element contained within the loaded document may be instantiated.
* An element's name may be used to decide the class that it is instantiated as.
* An element's arguments shall be passed to the element's object for processing.
* A element that is instantiated as an object must return a string.
* Dynamic element should not allow a CMS user to use server side functions to break the site.
#### Arguments
* An element's id may be used to load a specific arguments.
### Static
* Element's left uninstantiated are considered static as they do not change how they are delivered.
* No element must be instantiated.
## Hooks
* A instantiated object may feature hooks to orchestrate it's executing with other elements.
* Processor Hooks are used to decide the order of the objects method calls.