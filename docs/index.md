# Welcome to PXP documentation

![alt text](https://github.com/hxtree/PXP/raw/master/docs/logo/179x100.jpg "PXP")

PXP enables developers to use markup to build dynamic web pages.

# How it Works
PXP loads markup to instantiate objects, call their methods, and return an HTML document. 

## Overview
1. A `PageDirector` and `PageBuilder` objects are instantiated. 
2. The `PageDirector` is passed a `PageBuilder` object and an array of parameters defining the `Page` build, including:
- A `filename` string containing the URL or filepath to a XML or HTML document that will be inputted into the `PageBuilder`.
- A `handlers` array. Each `handler` must contain both Xpath expressions, which is used to lookup elements, and class 
name that is used to determine how that element once found will be instantiated as a Component.
- A `hooks` array. Each `hook` is essentially a method that will be made against all Components.
3. The `PageBuilder` loads the `filename` as a string and prefixes it with a HTML5 <!doctype> containing HTML5 entities.
4. That string is then converted into a Document Object Model for manipulation.
5. The `PageBuilder` using handlers Xpath expressions to find specified elements. 
6. Each element found is instantiated as a object using the `hooks` defined class and element is temporarily marked with a placeholder attribute.
7. Defined method calls `hooks` are made against all instantiated `Component` objects with defined methods.
8. If the hook is marked to render the object is converted to a string and replace the DOM element from which they were
instantiated from.
9. A dynamic page is then returned.

# Examples
See how PXP can be used through our [Examples](https://github.com/hxtree/PXP/blob/master/examples/README.md).

# `PageDirector`
The PageDirector is passed a PageBuilder and parameters (containing a HTML/XML document and a list of elements to make
dynamic), it then instantiates those elements as objects using their attributes and arguments, orchestrates method calls 
to those objects (hooks), replaces the element with returned value from a method call, and returns provides the parsed
document.

## `PageBuilder`
The PageBuilder receives parameters passed from the PageDirector and uses them to instantiate and return a Page object.

## `Page`
The Page loads a DOM object and uses Handlers and Hooks to instantiate Components and modify the DOM.

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
The PXP director is passed a loaded Document, a list Handlers, and Hooks. 
It finds and instantiate Elements using Handlers. 
Then, the Director iterates through the Hooks making call to Element's with those methods. 
Afterwards, the processed Document is returned.

#### `Arguments`
The Component constructor is passed a Page DOM elment's attributes ("id", "name", etc.) and "arg" tag child elements.

# Component Variable Scope
TODO: In Progress
All Components have access their own private variables. In addition, they can access their ancestors public variables.
Consider the following:

```HTML
 <div id="1">
 	<div id="2">
 		<div id="3"/>
 	</div>
 	<div id="4">
 		<div id="5"/>
 	</div>
 </div>
```

* id #1 can access no other Component public properties. 
* id #2 can access #1 Component public properties.
* id #3 can access #1 and #2 Component public properties.
* id #4 can access #1 Component public properties.
* id #5 can access #4 and $1 Component public properties.