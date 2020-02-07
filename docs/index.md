# Welcome to LivingMarkup documentation

![alt text](https://github.com/hxtree/LivingMarkup/raw/master/docs/logo/392x100.jpg "LivingMarkup")

***LivingMarkup is an PHP implementation of a Living Hypertext Markup Language (LHTML) parser.*** 
It instantiates DomElements as customizable backend components and orchestrates methods calls to build dynamic HTML.

# How it Works
LivingMarkup loads markup to instantiate objects, call their methods, and return an HTML document. 

![alt text](https://github.com/hxtree/LivingMarkup/raw/master/docs/diagrams/Class%20Diagram.png "Class Diagram")

## Overview
1. A `Director` object and an object using the `Builder` interface are instantiated. 
2. The `Director` is passed the `Builder` object and an array of parameters defining the `Engine` build, including:
- A `filename` string containing the URL or filepath to a XML or HTML document that will be inputted into the `Builder`.
- A `handlers` array. Each `handler` must contain both Xpath expressions, which is used to lookup elements, and class 
name that is used to determine how that element once found will be instantiated as a Component.
- A `hooks` array. Each `hook` is essentially a method that will be made against all Components.
3. The `Builder` loads the `filename` as a string and prefixes it with a HTML5 <!doctype> containing HTML5 entities.
4. That string is then converted into a Document Object Model for manipulation.
5. The `Builder` using handlers Xpath expressions to find specified elements. 
6. Each element found is instantiated as a object using the `hooks` defined class and element is temporarily marked with a placeholder attribute.
7. Defined method calls `hooks` are made against all instantiated `Component` objects with defined methods.
8. If the hook is marked to render the object is converted to a string and replace the DOM element from which they were
instantiated from.
9. A dynamic page is then returned.

# `Director`
The Director is passed a Builder and parameters (containing a HTML/XML document and a list of elements to make
dynamic), it then instantiates those elements as objects using their attributes and arguments, orchestrates method calls 
to those objects (hooks), replaces the element with returned value from a method call, and returns provides the parsed
document.

## `Builder`
The Builder receives parameters passed from the Director and uses them to instantiate and return a Page object.

## `Engine`
The Engine loads a DOM object and uses Handlers and Hooks to instantiate Components and modify the DOM.

### `Handlers`
A Handler consists of an XPath expressions and a class name and is used to define the Component. 
The XPath expression  ("//block") finds the elements inside the Page DOM. 
The class name defines the class used to instantiate elements found as Components.
A Handler's class name may feature variables ("/Blocks/{name}") that are resolved using the Page DOM element's 
attributes (<block name="Message"/>). 

### `Hooks`
Hooks are used to orchestrates method calls against all the Components instantiated.

## `Components`
The Component constructor is passed the DOM element's attributes, arguments, and stored parameters.
Components are most often used to replace DOM element with dynamic content.
Components should be designed for the content management system user with safe gaurds in place.
Only Page DOM elements with Handlers are instantiated as Components; the rest are generally static content.

### `Attributes`
A Handler can feature a Document's element name attribute to specify the object's class name. 
An Element's id attribute may be numerical to load Arguments.
The LivingMarkup director is passed a loaded Document, a list Handlers, and Hooks. 
It finds and instantiate Elements using Handlers. 
Then, the Director iterates through the Hooks making call to Element's with those methods. 
Afterwards, the processed Document is returned.

#### `Arguments`
The Component constructor is passed a Page DOM element's attributes ("id", "name", etc.) and "arg" tag child elements.