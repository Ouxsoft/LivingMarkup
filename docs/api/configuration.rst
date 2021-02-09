Configuration
=============

:Qualified name: ``Ouxsoft\LivingMarkup\Configuration``
:Implements: :interface:`ConfigurationInterface`

.. php:class:: Configuration

  .. php:method:: __construct (DocumentInterface`  $document[, ?string $config_file_path])

    :class:`Configuration` constructor

    :param DocumentInterface $document:
    :param string $config_file_path:
      Default: ``null``

  .. php:method:: addElement (array $element)

    Adds a element

    :param array $element:

  .. php:method:: addElements (array $elements)

    Adds multiple elements at once

    :param array $elements:

  .. php:method:: addRoutine (array $routine)

    Adds a routine

    :param array $routine:

  .. php:method:: addRoutines (array $routines)

    Adds multiple routines at once

    :param array $routines:

  .. php:method:: clearConfig ()

    Clear config


  .. php:method:: getElements () -> array

    Get elements

    :returns: array -- 

  .. php:method:: getMarkup () -> string

    Get source

    :returns: string -- 

  .. php:method:: getRoutines () -> array

    Get routines

    :returns: array -- 

  .. php:method:: loadFile ([])

    load a configuration file

    :param string $filepath:
      Default: ``null``
    :returns: void

  .. php:method:: setConfig (array $config)

    Set entire config at once

    :param array $config:

  .. php:method:: setMarkup (string $markup)

    Set LHTML source/markup

    :param string $markup:

