Processor
=========

The ``Processor`` is the primary object instantiated and used within this library.

ParseBuffer() Example
~~~~~~~~~~~~~~~~~~~~~

Shows a ``Processor`` with ``Elements`` and ``Routines`` defined during runtime processing the output
buffer of the file.

.. code:: php
    <?php
    use Ouxsoft\LivingMarkup\Factory\ProcessorFactory;

    $processor = ProcessorFactory::getInstance();

    $processor->addElement([
        'xpath' => '//partial',
        'class_name' => 'Partial\{name}'
    ]);

    $processor->addRoutine([
        'method' => 'onRender',
        'execute' => 'RETURN_CALL'
    ]);

    $processor->parseBuffer();
    ?>
    <html lang="en">
        <partial name="Alert" type="success">
            This is a success alert.
        </partial>
    </html>

Outputs:

.. code:: html5
    <!doctype html>
    <html lang="en">
        <div class="alert success" role="alert">
            This is a success alert
        </div>
    </html>


ParseBuffer() Inside Router Example
~~~~~~~~~~~~~~~~~~~~~

A server-side markup abstraction layer example. Shows using ParseBuffer inside a third party \
router to prevent the need to declare the ``Processor`` within each file.

.. code:: php
    <?php

    use Ouxsoft\LivingMarkup\Factory\ProcessorFactory;
    use Ouxsoft\Hoopless\Router;

    require_once '../vendor/autoload.php';

    // define common directories
    define('ROOT_DIR', dirname(__DIR__, 1) . '/');
    define('PUBLIC_DIR', ROOT_DIR . 'public/');
    define('ASSET_DIR', ROOT_DIR . 'assets/');
    define('IMAGE_DIR', ASSET_DIR . 'images/');
    define('CONFIG_DIR', ROOT_DIR . 'config/');

    // set include path
    set_include_path(ROOT_DIR);

    // instantiate processor with configuration and set to parse buffer
    global $processor;
    $processor = ProcessorFactory::getInstance();
    $processor->loadConfig(CONFIG_DIR . 'config.dist.json');
    $processor->parseBuffer();

    // Route traffic to a specific file
    $router = new Router();
    $router->response();

    // if response is a blank document chances are the page is missing a root element


ParseFile() Example
~~~~~~~~~~~~~~~~~~~~~~~~

Shows a ``Processor`` defined with ``Elements`` and ``Routines`` defined in a loaded config
and a parse file containing markup.

.. code:: php
    <?php
    use Ouxsoft\LivingMarkup\Factory\ProcessorFactory;

    $processor = ProcessorFactory::getInstance();

    $processor->loadConfig('config.json');
    $processor->parseFile('index.html')

Outputs:

.. code:: html5
    <!doctype html>
    <html lang="en">
        <div class="alert success" role="alert">
            This is a success alert
        </div>
    </html>


ParseString() Example
~~~~~~~~~~~~~~~~~~~~~~~~

Shows a ``Processor`` with ``Configuration`` ``Elements`` and ``Routines`` manually defined
parsing a string.

.. code:: php
    <?php
    use Ouxsoft\LivingMarkup\Factory\ProcessorFactory;

    $processor = ProcessorFactory::getInstance();

    $processor->addElement([
        'xpath' => '//partial',
        'class_name' => 'Partial\{name}'
    ]);

    $processor->addRoutine([
        'method' => 'onRender',
        'execute' => 'RETURN_CALL'
    ]);

    $processor->parseString('<html lang="en">
        <partial name="Alert" type="success">
            This is a success alert.
        </partial>
    </html>');

Outputs:

.. code:: html5
    <!doctype html>
    <html lang="en">
        <div class="alert success" role="alert">
            This is a success alert
        </div>
    </html>