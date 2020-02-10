# LHTML5 Standards

LHTML5 stands for Living Hypertext Markup Language 5. Prior to parsing LHTML5 looks similar to HTML5 with the possible addition of custom elements. When a page is built for a end user the parsed an LHTML5 document looks like an fully built out HTML5 page.

```html5
<html>
    <block name="NavBar" style="light"/>
    <h1>News &amp; Events</h1>
    <news>
        <arg name="limit">20</arg>
        <arg name"style">thumnail</arg>
    </news>
    <footer/>
</html>
```

## Component
Components are instantiated as object from DomElements. Not all elements are parsed, only Components defined in the parser config are turned to objects, the rest remain. A component can either be an existing HTML5 tag or a new tag, which is often referred to as a "LHTML5 tag". 
```html5
<block/>
```

The parser config is used to determine which class to instantiate the component as. The parser config may state that an element's class is included in decided which class to use. Depending on the config, the following may show an example of a component that is instantiated as the class `Components/Block/Test` or `Components/Block`.

```html5
<block name="Test"/>
```

## Arguments
During runtime the parser takes specified elements and instantiates them as objects. 
The element can feature arguments that may be used by the Component. An arguments purpose is to be passed as a parameter, used by a component's method.

### Attribute Arguments
Arguments can be added as attributes within an element. The following is an example of an argument `limit` being set to 1.
```lhtml5
<block name="Test" limit="1"/>
```
### Child Arguments
Using arguments in the form of attributes has its limitations. Arguments can also be added as a children of the element using the `arg` element. In the following example, `block` features an arg named `min` set to a value of 0 and an arg `limit` set to a value of 1. 
```lhtml5
<block name="Test">
    <arg name="min">0</arg>
    <arg name="limit">1</arg>
</block>
```
### Array Arguments
When multiple arguments are passed using the same name it creates an argument array. The following arg `type` contains an array with three values: pickles, ketchup, and mustard.
```lhtml5
<block name="Test">
    <arg name="type">pickles</arg>
    <arg name="type">ketchup</arg>
    <arg name="type">mustard</arg>
</block>
```

## Components
### Nested Components
Components can be nested inside one another. The following shows an example of a `var`, which is short for variable, component nested inside a `block` component.
```html5
<block name="UserProfile">
    <var name="fist_name"/>
</block>
```

#### Component Ancestor Properties
+ Components can access their own private variables. 
+ Components can access their ancestors public variables.

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
If `div` were a component in the above example, the following would be true:
* Component with id #1 can access no other Component public properties. 
* Component with id #2 can access component #1 public properties.
* Component with id #3 can access components #1 and #2 public properties.
* Component with id #4 can access component #1 public properties.
* Component with id #5 can access components #4 and #1 public properties.

## Component Hooks
The config defines method calls to be orchestrated against all the components instantiated, called "hooks". The hooks can differ project to project but it stands to reason that one of the last hooks called will render an output from the component and its content will replace the original element entirely,