![alt text](https://github.com/hxtree/PXP/raw/master/site/assets/images/pxp/logo/179x100.jpg "PXP")

> "PXP is for HTML what SASS is for CSS."

# Overview
PXP (PHP XML Preprocessor) is a server-side object-oriented approach to handling HTML/XML transformations.
In PXP, any HTML/XML element can be instantiated with arguments from the elements attributes as an object. 
Allowing for easier design and maintaince of a website's static and dynamic content. Although PXP is not 
limited by implementation, it lends itself well to a Content Management WYSIWYG.

## Example
Take a look at this example to get a feel for how you might use PXP. Remember you can use any tag, 
established or not, and decide what it does and ultimately look like when it's encountered using a 
PXP Class.

Input
```php
<body>
    <condition toggle="signed_in">
	<h2>Welcome, <var name="user.first_name"/></h2>
	<block name="Messages" limit="5"/>
    </condtion>
</body>
```

Output
```HTML
<body class="page">
	<h2>Welcome, Smith</h2>
	<div class="messages">
		<p>You have no new messages</p>
	</div>
</body>
```

## Version
Version 0.1.3 Pre-alpha

### Naming Convention
The version name consists of three numbers each separated by a period. The first number is the major version,
the next is the minor version and the last is the patch version. 

# Guidelines for PXP Implementations
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



