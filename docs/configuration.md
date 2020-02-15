# Configuration
The `Configuration` class determines how the LHTML5 document is parsed. It contains a et of instructions provided to the `Builder` class. 

The configuration is loaded from a `config.yml` or `config.dist.yml` file. Each file may contain the following fields.

## `modules`
### `types`
Module types is an array containing information about each module to make. 
- Each entry must contain both `xpath` expressions, which is used to lookup elements.
- Each entry must contain a `class_name` that is used to determine how an DomElement once found, will be instantiated. The `class_name` should extend the abstract Module class.

### `methods` 
Module methods are provided in the config. The order of methods determines the chain of execution. 
- A `name` should correlate to the method being executed.
- A `description` should be provided explaining what the method is doing.
- A `execute` command is option. It determines whether the method should be ran differently. Currently there are the following `execute` commands:
  - RETURN_CALL - which is used to replace the DomElement with the output of the method. 

## Source
The source is the string containing the LHTML5 document. Unlike other values this is typically not set in the `config.yml` file but is added to the `Configuration` during runtime, often by the `Autoloader`. The source my either come from a `filename` that will be loaded or directly from a string containing LHTML5 called `markup`. If both are provided `markup` will be used.
- A `markup` string contains the actual LHTML5 that will be parsed by the `Builder`.
- A `filename` string containing the URL or filepath to a XML or HTML document that will be inputted into the `Builder`.