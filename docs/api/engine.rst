Engine
======

:Qualified name: ``Ouxsoft\LivingMarkup\Engine``
:Implements: :interface:`EngineInterface`

.. php:class:: Engine

  .. php:method:: public __construct (DocumentInterface`  $document, ElementPoolInterface`  $element_pool)

    :class:`Engine` constructor.

    :param DocumentInterface`  $document:
    :param ElementPoolInterface`  $element_pool:

  .. php:method:: public __toString () -> string

    Returns DomDocument property as HTML5

    :returns: string -- 

  .. php:method:: public callRoutine (array $routine)

    Call Hooks

    :param array $routine:
    :returns: bool-

  .. php:method:: public getDomElementByPlaceholderId (string $element_id)

    Gets DOMElement using element_id provided

    :param string $element_id:
    :returns: DOMElement|null

  .. php:method:: public getElementAncestorProperties (string $element_id) -> array

    Get a Element ancestors' properties based on provided element_id DOMElement's ancestors

    :param string $element_id:
    :returns: array -- 

  .. php:method:: public getElementArgs (DOMElement $element) -> ArgumentArray

    Get DOMElement's attribute and child <args> elements and return as a single list items within the list are called args as they are passed as parameters to element methods

    :param DOMElement $element:
    :returns: :class:`ArgumentArray` -- 

  .. php:method:: public getElementInnerXML (string $element_id) -> string

    Get Element inner XML

    :param string $element_id:
    :returns: string -- 

  .. php:method:: public instantiateElements (array $lhtml_element) -> bool

    Instantiates elements from DOMElement's found during Xpath query against DOM property

    :param array $lhtml_element:
    :returns: bool -- 

  .. php:method:: public queryFetch (string $query[, DOMElement $node]) -> mixed

    XPath query for class $this->DOM property that fetches only first result

    :param string $query:
    :param DOMElement $node:
      Default: ``null``
    :returns: mixed -- 

  .. php:method:: public queryFetchAll (string $query[, DOMElement $node]) -> mixed

    XPath query for class $this->DOM property that fetches all results as array

    :param string $query:
    :param DOMElement $node:
      Default: ``null``
    :returns: mixed -- 

  .. php:method:: public removeElements (array $lhtml_element)

    Removes elements from the DOM

    :param array $lhtml_element:
    :returns: void

  .. php:method:: public renderElement (string $element_id) -> bool

    Within DOMDocument replace DOMElement with Element->:class:`__toString()` output

    :param string $element_id:
    :returns: bool -- 

  .. php:method:: public replaceDomElement (DOMElement $element, string $new_xml)

    Replaces DOMElement from property DOM with contents provided

    :param DOMElement $element:
    :param string $new_xml:

  .. php:method:: public setType ([])

    Set a value type to avoid Type Juggling issues and extend data types

    :param $value:
      Default: ``null``
    :param $type:
      Default: ``'string'``
    :returns: bool|mixed|string|null

  .. php:method:: private instantiateElement (DOMElement $element, string $class_name) -> bool

    Instantiate a DOMElement as a Element using specified class_name

    :param DOMElement $element:
    :param string $class_name:
    :returns: bool -- 

