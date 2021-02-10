Processor
=========

:Qualified name: ``Ouxsoft\LivingMarkup\Processor``

.. php:class:: Processor

  .. php:method:: public __construct (KernelInterface`  $kernel, ConfigurationInterface`  $config)

    :class:`Processor` constructor.

    :param KernelInterface`  $kernel:
    :param ConfigurationInterface`  $config:

  .. php:method:: public addElement (array $element)

    Add definition for processor LHTML element

    :param array $element:

  .. php:method:: public addElements (array $elements)

    Add definition for processor LHTML element

    :param array $elements:

  .. php:method:: public addRoutine (array $routine)

    Add definition for processor LHTML routine

    :param array $routine:

  .. php:method:: public addRoutines (array $routines)

    Add definition for processor LHTML routine

    :param array $routines:

  .. php:method:: public getBuilder ()

    Get builder

    :returns: BuilderInterface

  .. php:method:: public getConfig () -> Configuration

    Get config

    :returns: :class:`Configuration` -- 

  .. php:method:: public getStatus () -> bool

    Gets whether process runs or does not run

    :returns: bool -- 

  .. php:method:: public loadConfig (string $filepath)

    Load config

    :param string $filepath:

  .. php:method:: public parseBuffer ()

    Process output buffer


  .. php:method:: public parseFile (string $filepath) -> string

    Process a file

    :param string $filepath:
    :returns: string -- 

  .. php:method:: public parseString (string $source) -> string

    Process string

    :param string $source:
    :returns: string -- 

  .. php:method:: public setBuilder (string $builder_class)

    Set builder

    :param string $builder_class:

  .. php:method:: public setConfig (ConfigurationInterface $config)

    Set config

    :param ConfigurationInterface $config:
    :returns: void

  .. php:method:: public setStatus (bool $status)

    Set whether process runs or does not run

    :param bool $status:

  .. php:method:: private parse () -> string

    Parse using a :class:`Kernel` to build an :class:`Engine`

    :returns: string -- 

