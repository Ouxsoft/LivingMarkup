Entities
========

:Qualified name: ``Ouxsoft\LivingMarkup\Entities``

.. php:class:: Entities

  .. php:method:: fetchArray () -> array

    Download and encode entities from url

    :returns: array -- 

  .. php:method:: fetchString () -> string

    Fetches entity string for use in DomDocument Doctype declaration

    :returns: string -- 

  .. php:method:: getURL () -> string

    Get url of fetch point

    :returns: string -- 

  .. php:staticmethod:: get () -> string

    Get list of entities to pass to DOM. These will prevent the character from causing parse errors

    :returns: string -- 

