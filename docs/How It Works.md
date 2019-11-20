# Guidelines for PXP Implementations
## Director
The Director is passed a loaded Document, a list Handlers, and Hooks. It finds and instantiate Elements from the Document using Handlers. The Director then interates through the Hooks making call to Element's with those methods.
## Document
The Document is loaded by the Director. During runtime the Director modifies the Document using Handlers and Hooks. A Document must be well-formed and valid XML or HTML.
## Handlers
A Handler is used to define a type of Element. It consist of an XPath expressions and a class name. The XPath expression  ("//block") finds the Elements inside the Document. The class name defines the class used to instantiate the Element. A Handler's class name may feature variables ("/Blocks/{name}") for the Director to resolve using the Document element's attributes (<block name="Message"/>). PXP does not require any specific Handlers be implemented, although core Logic and Element Handlers are useful.
## Hooks
The Director orchestrates Element method execution using Hooks which are defined at runtime. Hooks order the execution of Element method calls.
## Elements
An Element is object instantiated by a Director and defined by a Handler. During construction, the Process sends the Document XML/HTML element's attributes, arguments, and content to the object which are all stored as property within the object. Elements are often used to return dynamic content which the Director uses to replace the Document's element. Element's should be designed for the CMS user, and have safe gaurds in place. Not every Document XML/HTML element is instantiated. Only those with a Handler are Elements. The rest are generally considered static content.
### Atrributes
A Handler can feature a Document's element name attribute to specify the object's class name. An Element's id attribute may be numerical to load Arguments.
The PXP director is passed a loaded Document, a list Handlers, and Hooks. It finds and instantiate Elements using Handlers. Then, the Director interates through the Hooks making call to Element's with those methods. Afterwards, the processed Document is returned.
#### Arguments
During instantiation to the object, an elment's attributes ("id","name", etc.) and child elements with tag "arg" are passed to the constructor for use.
