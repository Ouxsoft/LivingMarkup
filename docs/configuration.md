# Configuration
The `Configuration` class is responsible for the instructions that explain to the `Builder` how to build the LHTML `Document`. These instructions can be set by modifying the config file that is loaded.

## Config File 
The config file is where settings are configured. The `Configuration` class tries to load a `config.yml` if another file has not been specified during construction. If the `config.yml` not present, the `Configuration` will try to load the packaged config `config.dist.yml` file.

### Syntax v1

#### Example 
```yaml
version: 1
modules:
  types:
    - name: 'Block'
      class_name: 'LivingMarkup\Modules\Blocks\{name}'
      xpath: '//block'

  methods:
    - name: 'onRender'
      descirption: 'Execute rendering of module'
      execute: 'RETURN_CALL'
```

#### Parameters

| Parameter | Comments |
|---    | ---
| `version` | Indicates the file structure to the `Configuration` for stability purposes.|
| `modules` | An array containing configuration options for modules. |
| `modules:types` | An array containing the types of modules to load at runtime. Each type contains contain an array with a `name`, a `class_name`, and a `xpath` expression. |
| `module:types:*:name`  | Defines what the modules is named. | 
| `module:types:*:xpath` | Specifies exactly how find DOMElements to initialize as modules. Xpath expressions are a powerful syntax for searching within a the `Document` for DOMElements. |
| `module:types:*:class_name` | Specifies which class to instantiate the DOMElement as. The `class_name` provided must refer to a class that extends the abstract `Module` class. The class name may feature a `{name}` variable which is automatically populated by the DOMElement's name attribute during runtime. |
| `module:methods` | An array containing automated method calls that will be made to all Modules during runtime. The order of items in this array determines the order of execution. |
| `module:methods:*:name` |  The exact name of the method being executed. |
| `module:methods:*:description` | An explanation of what the method is doing that indicates its order. |
| `module:methods:*:execute` | Determines whether the method should be ran differently. Currently, the following commands are supported * RETURN_CALL - The output of the method will replace the DOMElement in the DOMDocument. Is optional |
| `markup:` | String containing the actual LHTML that will be parsed by the `Builder`. This field is typically omitted from the config file and is instead appended to `Configuration` during runtime, often by the `Autoloader`.|