# Configuration
The `Configuration` class contains a set of instructions provided to the `Builder` class that 
determines how the to build the LHTML5 `Document`.

The `Configuration` is loaded from a either a `config.yml` or `config.dist.yml` file. An example showing the structure of this file is provided below. 
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

## Config Fields
### `version`
`version` is a string containing the version information of the config. Only version 1 configs are currently supported.
### `modules`
`modules` is an array containing configuration options for modules.
### `module:types`
`module:types` is an array containing the types of runtime modules. Each type contains a `name`, a `class_name`, and a `xpath` expression.
- The `name` field defines what the modules is named. 
- The `xpath` field specifies how find DOMElements to turn into modules. An xpath expressions is a powerful syntax for searching within a the `Document` for DOMElements. It syntax allows for choosing exactly only the correct DOMElements.
- The `class_name` field specifies which class to instantiate the DOMElement as. The `class_name` provided must refer to a class that extends the abstract Module class.

#### `module:methods` 
`module:methods` is an array containing automated method calls that will be made to all Modules during runtime. The order of `module:methods` is important as it determines the order of execution. 
- A `name` should correlate to the method being executed.
- A `description` should be provided explaining what the method is doing.
- A `execute` command is optional. It determines whether the method should be ran differently. Currently, the following commands are supported:
  - RETURN_CALL - The output of the method will replace the DOMElement in the DOMDocument. 

## Source
The source is the string containing the LHTML5. Unlike other values this is not set in the `config.yml` file but is added to the `Configuration` during runtime, often by the `Autoloader`. The source my either come from a `filename` that will be loaded or directly from a string containing LHTML5 called `markup`. If both are provided `markup` will be used.
- A `markup` string contains the actual LHTML5 that will be parsed by the `Builder`.
- A `filename` string containing the URL or filepath to a XML or HTML document that will be inputted into the `Builder`.