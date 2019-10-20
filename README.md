![alt text](https://github.com/hxtree/PXP/raw/master/site/assets/images/pxp/logo/179x100.jpg "PXP")

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

Server Front End (/site/pages/dashboard)
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
PXP solves common Content Management System design flaws, but the framework is not limited to this implementions. Here's how PXP works.
## Modules
PXP consists of modules that can be swapped in and out using autoloading. This implementation has two different
module directories, core/modules and site/modules, that can be autoloaded as desired.  
## Processor
The PXP processor is passed a Document to load, a list Handlers, and Hooks. It starts by loading the Document. Next, using Handlers it finds and instantiate Elements. Then, the Processor interates through the Hooks making call to Element's with those methods. In then returns the Processed Document.
## Document
The PXP Document during runtime is loaded by the Process loads and modifies the Document using Handlers and Hooks. In order to be loaded, a Document must be either valid XML or HTML. When complete it delivers the processed Document as either valid XML or HTML.
## Handlers
A Handler is used to define a type of Element and consist of two main parts: an XPath expressions and a class name. The XPath expression finds Document elements ("//block"). The class name defines the class used to instantiate the Element. A Handler's class name may feature variables ("/Blocks/{name}") for the Processor to resolve using the Document element's attributes (<block name="Message"/>). PXP is modular, and does not require specific Handlers, although core Logic and Element are typically included.
## Hooks
The Processor orchestrate Element method execution using Hooks. Hooks are used to order and iterate through calls to Element methods.
## Elements
An Element is object instantiated by a Processor using a Handler. During construction, the Process sends the Document XML/HTML element's attributes, arguments, and content to the object which are all stored as property within the object. Elements typically return dynamic content in the form of a string which replaces the Process uses to replace the Document's element. Element's should be designed for the CMS user, and have safe gaurds in place. It is important to note, that not every Document XML/HTML element is instantiated, only those which have a handler are. The rest, are considered static content.
#### Atrributes
A Handler can a Document's element name attribute to specify the object's class name. An element's id attribute is used to load arguments.
#### Arguments
An elment's arguments are passed during instantiation to the object.
