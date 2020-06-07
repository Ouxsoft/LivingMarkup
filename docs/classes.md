# Classes
![alt text](https://github.com/hxtree/LivingMarkup/raw/master/assets/images/diagrams/Class%20Diagram.png "Class Diagram")

## Design Pattern
Pages are created using a Builder design pattern. This design pattern was chosen to separate the construction of the complex page objects from its representation. This allows pages to be built for different purposes, including:
+ The `DynamicBuilder` renders a dynamic Page for a client's browser.
+ The `StaticBuilder` renders a static Page for a WYSIWYG.
+ The `SearchBuilder` renders a dynamic Page with some Modules excluded for search indexes.

The Director is called the `Kernel` within the context of the Builder design pattern.

## Overview
`Processor` class provides a user API interface for setting the `Kernel`, `Configration`, and `Builders` setting.

# `Kernel`
The `Kernel` is passed a Builder and parameters (containing a HTML/XML document and a list of elements to make dynamic), it then instantiates those elements as objects using their attributes and arguments, orchestrates method calls 
to those objects, replaces the element with returned value from a method call, and returns provides the parsed `Document`.

## `Builder`
The `Builder` receives parameters passed from the `Kernel` and uses them to instantiate and return a `Document` object.

## `Engine`
The `Engine` loads a DOM object and modifies the `Document`.

### `Module Types`
A Module Type consists of an XPath expressions and a class name. It is used to define the Module. 
The XPath expression  ("//block") finds the elements inside the `Document`. 
The class name defines the class used to instantiate elements found as Modules. This class name may feature variables ("/Blocks/{name}") that are resolved using the Page DOM element's 
attributes (<block name="Message"/>). 

### `Automated Methods`
Automated Methods are used to orchestrates method calls against all instantiated Modules.

## `Modules`
The Module constructor is passed the DOM element's attributes, arguments, and stored parameters.
Modules are most often used to replace DOM element with dynamic content.
Modules should be designed for the content management system user with safe gaurds in place.
Only Page DOM elements with Handlers are instantiated as Modules; the rest are generally static content.

### `Attributes`
A Handler can feature a Document's element name attribute to specify the object's class name. 
An Element's id attribute may be numerical to load Arguments.
The LivingMarkup kernel is passed a loaded Document, a list Handlers, and Hooks. 
It finds and instantiate Elements using Handlers. 
Then, the Kernel iterates through the Hooks making call to Element's with those methods. 
Afterwards, the processed Document is returned.

#### `Arguments`
The Module constructor is passed a Page DOM element's attributes ("id", "name", etc.) and "arg" tag child elements.