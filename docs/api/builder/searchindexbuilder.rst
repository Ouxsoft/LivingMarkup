SearchIndexBuilder
==================

:Qualified name: ``Ouxsoft\LivingMarkup\Builder\SearchIndexBuilder``
:Implements: :interface:`BuilderInterface`

.. php:class:: SearchIndexBuilder

  .. php:method:: public __construct (EngineInterface`  $engine, ConfigurationInterface`  $config)

    :param EngineInterface`  $engine:
    :param ConfigurationInterface`  $config:

  .. php:method:: public createObject ()

    Creates Page object using parameters supplied omits elements with search_engine = false

    :returns: void

  .. php:method:: public getObject () -> Engine

    Gets Page object

    :returns: :class:`Engine` -- 

