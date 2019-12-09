// TODO MAKE THIS MAKE SENSE
// FOR NOW PLEASE SEE EXAMPLES

## Why PXP?
PXP stands for PHP XML Preprocessor.



A PageDirector is passed a PageBuilder and parameters (containing a HTML/XML document and a list of elements to make
dynamic), it then instantiates those elements as objects using their attributes and arguments, orchestrates method calls 
to those objects (hooks), replaces the element with returned value from a method call, and returns provides the parsed
document. 

# Design Pattern
PXP uses a Builder design pattern to build Pages featuring DynamicElements.

## PageDirector
The PageDirector is passed a PageBuilder and parameters, such as the path to be loaded, Handlers, and Hooks. 

## PageBuilder
The PageBuilder receives parameters passed from the PageDirector that is uses to instantiate and return a Page object.

## Page
A Page loads a DOM object and uses Handlers and Hooks to instantiate DynamicElements and modify the DOM.

## Handlers
A Handler consists of an XPath expressions and a class name and is used to define the DynamicElement. 
The XPath expression  ("//block") finds the elements inside the Page DOM. 
The class name defines the class used to instantiate elements found as DynamicElements.
A Handler's class name may feature variables ("/Blocks/{name}") that are resolved using the Page DOM element's attributes (<block name="Message"/>). 

## Hooks
Hooks are used to orchestrates method calls against all the DynamicElements instantiated.

## DynamicElements
The DynamicElement constructor is passed the DOM element's attributes, arguments, and stored parameters.
DynamicElements are most often used to replace DOM element with dynamic content.
DynamicElements should be designed for the content management system user with safe gaurds in place.
Only Page DOM elements with Handlers are instantiated as DynamicElements; the rest are generally static content.

### Attributes
A Handler can feature a Document's element name attribute to specify the object's class name. 
An Element's id attribute may be numerical to load Arguments.
The PXP director is passed a loaded Document, a list Handlers, and Hooks. 
It finds and instantiate Elements using Handlers. 
Then, the Director interates through the Hooks making call to Element's with those methods. 
Afterwards, the processed Document is returned.

#### Arguments
The DynamicElement constructor is passed a Page DOM elment's attributes ("id", "name", etc.) and "arg" tag child elements.

# Example

your-markup.html
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
