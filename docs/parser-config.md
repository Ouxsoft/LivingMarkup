# Parser Config
The Parser Config determines how the LHTML5 document is parsed. It contains some basic information that helps render pages differently.

## Source Definition
The source is the string version of the LHTML5 document that the parser receives. 
- A `filename` string containing the URL or filepath to a XML or HTML document that will be inputted into the `Builder`.

## Module Definition
- A `handlers` array. Each `handler` must contain both Xpath expressions, which is used to lookup elements, and class.

## Hook Definition 
name that is used to determine how that element once found will be instantiated as a Module.
- A `hooks` array. Each `hook` is essentially a method that will be made against all Modules.
