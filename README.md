![alt text](https://github.com/hxtree/PXP/raw/master/site/assets/images/pxp/logo/179x100.jpg "PXP")

# Overview
PXP (PHP XML Preprocessor) is a server-side object-oriented approach to XML transformations.
In PXP any desired XML element can become instantiated as an object and processed.

This PXP implementation is designed around Content Management System. PXP design allows 
for handling of both static and dynamic content making it suited for the web.

In short, PXP allows you to take this:

```php
<body>
    <block name="Test">
        <arg name="heading">Hello World</arg>
    </block>
</body>
```

```HTML
<body>
    <div name="TestBlock">
	<h1>Hello World</h1>
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
Processors may load only valid XML or HTML documents.
No element must be instantiated.	
Any element contained within the loaded document may be instantiated.
An element's name may be used to decide the class that it is instantiated as.
An element's id may be used to load a specific arguments.
An element's arguments shall be passed to the element's object for processing.
A element that is instantiated as an object must return a string.
A instantiated object may feature hooks to orchestrate it's executing with other elements.
A processed PXP document must return valid XML or HTML.
