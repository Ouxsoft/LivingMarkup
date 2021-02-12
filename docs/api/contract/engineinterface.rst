EngineInterface
===============

:Qualified name: ``Ouxsoft\LivingMarkup\Contract\EngineInterface``

.. php:interface:: EngineInterface

  .. php:method:: public __construct (DocumentInterface`  $document, ElementPoolInterface`  $element_pool)

    :param DocumentInterface`  $document:
    :param ElementPoolInterface`  $element_pool:

  .. php:method:: public __toString ()


  .. php:method:: public callRoutine (array $routine)

    :param array $routine:

  .. php:method:: public getDomElementByPlaceholderId (string $element_id)

    :param string $element_id:

  .. php:method:: public getElementAncestorProperties (string $element_id)

    :param string $element_id:

  .. php:method:: public getElementArgs (DOMElement $element)

    :param DOMElement $element:

  .. php:method:: public getElementInnerXML (string $element_id)

    :param string $element_id:

  .. php:method:: public instantiateElements (array $lhtml_element)

    :param array $lhtml_element:

  .. php:method:: public queryFetch (string $query[, DOMElement $node])

    :param string $query:
    :param DOMElement $node:
      Default: ``null``

  .. php:method:: public queryFetchAll (string $query[, DOMElement $node])

    :param string $query:
    :param DOMElement $node:
      Default: ``null``

  .. php:method:: public removeElements (array $lhtml_element)

    :param array $lhtml_element:

  .. php:method:: public renderElement (string $element_id)

    :param string $element_id:

  .. php:method:: public replaceDomElement (DOMElement $element, string $new_xml)

    :param DOMElement $element:
    :param string $new_xml:

  .. php:method:: public setType ([])

    :param $value:
      Default: ``null``
    :param $type:
      Default: ``'string'``

