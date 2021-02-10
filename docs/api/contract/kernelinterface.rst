KernelInterface
===============

:Qualified name: ``Ouxsoft\LivingMarkup\Contract\KernelInterface``

.. php:interface:: KernelInterface

  .. php:method:: __construct (EngineInterface`  $engine, BuilderInterface`  $builder, ConfigurationInterface`  $config)

    :param EngineInterface`  $engine:
    :param BuilderInterface`  $builder:
    :param ConfigurationInterface`  $config:

  .. php:method:: build ()


  .. php:method:: getBuilder ()


  .. php:method:: getConfig ()


  .. php:method:: setBuilder (string $builder_class)

    :param string $builder_class:

  .. php:method:: setConfig (ConfigurationInterface $config)

    :param ConfigurationInterface $config:

