# Welcome to PXP documentation

![alt text](https://github.com/hxtree/PXP/raw/master/docs/logo/179x100.jpg "PXP")

***PXP enables markup to instantiate objects, call methods, and generate HTML.*** It works similar to a server-side 
templating engine, but rather than enforcing braces it enables developers to use markup to build dynamic web pages.

# Examples
See how PXP can be used through our [Examples](https://github.com/hxtree/PXP/blob/master/examples/README.md).

# Design Pattern
Pages are created using a Builder design pattern. This design pattern was chosen to separate the construction of the 
complex page objects from its representation to build pages for different purposes, e.g.
+ The DynamicBuilder renders a dynamic Page for the client.
+ The StaticBuilder renders a static Page for a WYSIWYG.
+ The SearchBuilder renders a dynamic Page with only some DynamicElements for search indexes.

# PageDirector
The PageDirector is passed a PageBuilder and parameters (containing a HTML/XML document and a list of elements to make
dynamic), it then instantiates those elements as objects using their attributes and arguments, orchestrates method calls 
to those objects (hooks), replaces the element with returned value from a method call, and returns provides the parsed
document.

## PageBuilder
The PageBuilder receives parameters passed from the PageDirector and uses them to instantiate and return a Page object.

## Page
The Page loads a DOM object and uses Handlers and Hooks to instantiate DynamicElements and modify the DOM.

### Handlers
A Handler consists of an XPath expressions and a class name and is used to define the DynamicElement. 
The XPath expression  ("//block") finds the elements inside the Page DOM. 
The class name defines the class used to instantiate elements found as DynamicElements.
A Handler's class name may feature variables ("/Blocks/{name}") that are resolved using the Page DOM element's 
attributes (<block name="Message"/>). 

### Hooks
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

## Why "PXP?"
PXP stands for PHP XML Preprocessor.