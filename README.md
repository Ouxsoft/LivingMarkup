![alt text](https://github.com/hxtree/PXP/raw/master/site/assets/images/pxp/logo/179x100.jpg "PXP")

# Overview
PXP (PHP XML Preprocessor) is a server-side object-oriented approach to handling XML transformations.
In PXP any XML element desired can be instantiated with arguments as an object. This makes
it easy to maintain both a website's static and dynamic content. Although PXP is not limited by
implementation, this is a Content Management System. 


## Example
Take a look at this simple example to get a feel for how you migh use PXP. Remember you 
can use any tag, established or not, and decide what it does and ultimately look like when 
it's encountered.

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

# Principle Assumptions
A Content Management System should:
* Allow authenticated users to change server side logic related how data is display.
* Prevent any CMS user from using server side functions to break the site.
* Be easy to edit and understand from both an XML/HTML and WYSIWYG.
* Be scalable
* Keep it simiple.
* Help editors adhere to the DRY (don't repeat yourself) design principle.
* Allow for easy dyanmic content management
* XSLT (eXtensible Stylesheet Language) is bad.

# Guidelines for PXP Implementations
* Processors may load only valid XML or HTML documents.
* No element must be instantiated.	
* Any element contained within the loaded document may be instantiated.
* An element's name may be used to decide the class that it is instantiated as.
* An element's id may be used to load a specific arguments.
* An element's arguments shall be passed to the element's object for processing.
* A element that is instantiated as an object must return a string.
* A instantiated object may feature hooks to orchestrate it's executing with other elements.
* A processed PXP document must return valid XML or HTML.
