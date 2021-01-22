# Configuration
The `Configuration` class is responsible for the instructions that explain to the `Builder` how to build the LHTML `Document`. These instructions can be set by modifying the config file that is loaded.

## Config File
Set configurations in the config file. 

### Syntax v1

#### Example 
```json
{
   "version": 1,
   "elements": {
      "types": [
         {
            "name": "Block",
            "class_name": "LivingMarkup\\Elements\\Blocks\\{name}",
            "xpath": "//block"
         }
      ],
      "methods": [
         {
            "name": "onRender",
            "description": "Execute rendering of element",
            "execute": "RETURN_CALL"
         }
      ]
   }
}
```

### Autoloading
If a file has been specified during construction, it will be loaded.
If a file has not been specified the `Configuration` class tries to 
load a `config.json` file if present.

If the `config.json` is not present, the `Configuration` will try to load the 
packaged config `config.dist.json` file.

#### Parameters

| Parameter | Comments |
|---    | ---
| `version` | Indicates the file structure to the `Configuration` for stability purposes.|
| `elements` | An array containing configuration options for elements. |
| `elements:types` | An array containing the types of elements to load at runtime. Each type contains contain an array with a `name`, a `class_name`, and a `xpath` expression. |
| `element:types:*:name`  | Defines what the elements is named. | 
| `element:types:*:xpath` | Specifies exactly how find DOMElements to initialize as elements. Xpath expressions are a powerful syntax for searching within a the `Document` for DOMElements. |
| `element:types:*:class_name` | Specifies which class to instantiate the DOMElement as. The `class_name` provided must refer to a class that extends the abstract `Element` class. The class name may feature a `{name}` variable which is automatically populated by the DOMElement's name attribute during runtime. |
| `element:methods` | An array containing automated method calls that will be made to all Elements during runtime. The order of items in this array determines the order of execution. |
| `element:methods:*:name` |  The exact name of the method being executed. |
| `element:methods:*:description` | An explanation of what the method is doing that indicates its order. |
| `element:methods:*:execute` | Determines whether the method should be ran differently. Currently, the following commands are supported * RETURN_CALL - The output of the method will replace the DOMElement in the DOMDocument. Is optional |
| `markup:` | String containing the actual LHTML that will be parsed by the `Builder`. This field is typically omitted from the config file and is instead appended to `Configuration` during runtime, often by the `Autoloader`.|