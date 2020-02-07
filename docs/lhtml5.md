# LHTML5 Standards

LHTML5 stands for Living Hypertext Markup Language 5. LHTML5 looks much like HTML5 with the addition of custom elements called components.

## Component
A component can be either an existing HTML tag or a new HTML tag.
```html5
<block/>
```

## Arguments
During runtime the parser takes specified elements and instantiates them as objects. 
The element can feature arguments that may be used by the Component. An arguments purpose is to be passed as a parameter, used by a component's method.

### Attribute Arguments
Arguments may also be included as attributes within an element. The following is an example of and argument `limit`.
```lhtml5
<block name="Test" limit="1"/>
```
### Child Arguments
Arguments may be included as child elements using the `arg` element. In the following example `block` features an arg called `limit`.
```lhtml5
<block name="Test">
    <arg name="limit">1</arg>
</block>
```
### Array Arguments
Multiple arguments can be passed using the the same name to form an argument array. The following arg `type` contains an array with three values: pickles, ketchup, and mustard.
```lhtml5
<block name="Test">
    <arg name="type">pickles</arg>
    <arg name="type">ketchup</arg>
    <arg name="type">mustard</arg>
</block>
```

## Nested Components
Components can be nested inside one another. The following shows an example of a `var` (variable) component nested inside a `block` component.
```html5
<block name="UserProfile">
    <var name="fist_name"/>
</block>
```

### Component Ancestor Properties
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