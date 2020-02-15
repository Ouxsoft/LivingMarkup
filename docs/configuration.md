# Configuration
The `Configuration` class contains a set of instructions provided to the `Builder` class that 
determines how the LHTML5 document is built.

The configuration is loaded from a `config.yml` or `config.dist.yml` file shown below. 
```yaml
version: 1
modules:
  types:
    - name: 'Block'
      class_name: 'LivingMarkup\Modules\Blocks\{name}'
      xpath: '//block'

  methods:
    - name: 'beforeLoad'
      descirption: 'Execute before object data load'
```

## `module:types`
`module:types` is an array containing information on how to find and process modules within the page. 
- A `xpath` expression is required to find elements to instantiate. Xpath is a powerful syntax for searching for elements within a DOMDocument. It can be useful for choosing exactly which elements quality for the instantiation.
- A `class_name` is required to determine how an DomElement found from the xpath query will be instantiated. The `class_name` provided shall be for a Module that extends the abstract Module class.

### `module:methods` 
`module:methods` is an array of automated method calls that will be made to all Modules during runtime. The order of `module:methods` is important as it determines the order of execution. 
- A `name` should correlate to the method being executed.
- A `description` should be provided explaining what the method is doing.
- A `execute` command is optional. It determines whether the method should be ran differently. Currently, the following commands are supported:
  - RETURN_CALL - The output of the method will replace the DOMElement in the DOMDocument. 

## Source
The source is the string containing the LHTML5. Unlike other values this is not set in the `config.yml` file but is added to the `Configuration` during runtime, often by the `Autoloader`. The source my either come from a `filename` that will be loaded or directly from a string containing LHTML5 called `markup`. If both are provided `markup` will be used.
- A `markup` string contains the actual LHTML5 that will be parsed by the `Builder`.
- A `filename` string containing the URL or filepath to a XML or HTML document that will be inputted into the `Builder`.