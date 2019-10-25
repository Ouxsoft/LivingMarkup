![alt text](https://github.com/hxtree/PXP/raw/master/docs/logo/179x100.jpg "PXP")

***PXP turns markup into code.*** It allows front end and back end developers to work together.

Web Browser
```HTML
<body class="page">
	<h2>Welcome, Jane</h2>
	<div class="messages">
		<p>You have no new messages.</p>
	</div>
</body>
```

Server Front End
```XML
<body>
	<condition toggle="signed_in">
	<h2>Welcome, <var name="first_name"/></h2>
	<block name="Messages" limit="5"/>
	</condtion>
</body>
```

Server Back End
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

# Quick start

Install with Composer: `composer require hxtree/pxp`

# Guidelines for PXP Implementations
Here's how PXP works.
## Processor
The PXP processor is passed a Document to load, a list Handlers, and Hooks. It starts by loading the Document. Next, using Handlers it finds and instantiate Elements. Then, the Processor interates through the Hooks making call to Element's with those methods. Afterwards, the processed Document is returned.
## Document
The PXP Document is loaded by the PXP Processor. During runtime the Processor modifies the Document using Handlers and Hooks. A Document must be well-formed and valid XML or HTML.
## Handlers
A Handler is used to define a type of Element and consist of two main parts: an XPath expressions and a class name. The XPath expression finds Document elements ("//block"). The class name defines the class used to instantiate the Element. A Handler's class name may feature variables ("/Blocks/{name}") for the Processor to resolve using the Document element's attributes (<block name="Message"/>). PXP  does not require any specific Handlers be implemented, although core Logic and Element Handlers are often useful.
## Hooks
The Processor orchestrates Element method execution using Hooks which are defined at runtime. Hooks order the execution of Element method calls.
## Elements
An Element is object instantiated by a Processor and defined by a Handler. During construction, the Process sends the Document XML/HTML element's attributes, arguments, and content to the object which are all stored as property within the object. Elements are often used to return dynamic content which the Processor uses to replace the Document's element. Element's should be designed for the CMS user, and have safe gaurds in place. It is important to note, that not every Document XML/HTML element is instantiated, only those which have a Handler are Elements. The rest, are essentially static content.
#### Atrributes
A Handler can feature a Document's element name attribute to specify the object's class name. An Element's id attribute is often numerical and intended to load arguments.
#### Arguments
During instantiation to the object, an elment's attributes ("id","name", etc.) and child elements with tag "arg" are passed to the constructor for use.
