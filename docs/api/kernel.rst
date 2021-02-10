Kernel
======

:Qualified name: ``Ouxsoft\LivingMarkup\Kernel``
:Implements: :interface:`KernelInterface`

.. php:class:: Kernel

  .. php:method:: public __construct (EngineInterface`  $engine, BuilderInterface`  $builder, ConfigurationInterface`  $config)

    :class:`Kernel` constructor.

    :param EngineInterface`  $engine:
    :param BuilderInterface`  $builder:
    :param ConfigurationInterface`  $config:

  .. php:method:: public build () -> Engine

    Calls Builder using parameters supplied

    :returns: :class:`Engine` -- 

  .. php:method:: public getBuilder ()

    Get builder

    :returns: BuilderInterface

  .. php:method:: public getConfig ()

    Get config

    :returns: ConfigurationInterface

  .. php:method:: public setBuilder (string $builder_class)

    Set builder

    :param string $builder_class:

  .. php:method:: public setConfig (ConfigurationInterface $config)

    Set config

    :param ConfigurationInterface $config:

