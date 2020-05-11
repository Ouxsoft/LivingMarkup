<p align="center"><img src="https://github.com/hxtree/LivingMarkup/raw/master/assets/images/logo/434x100.jpg" width="400"></p>

<p align="center">
<a href="https://app.codacy.com/manual/hxtree/LivingMarkup?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=hxtree/LivingMarkup&amp;utm_campaign=Badge_Grade_Dashboard"><img src="https://api.codacy.com/project/badge/Grade/bfc76aaebde44a7fa239963e54883755" alt="Codacy Badge"></a>
<a href="https://github.com/hxtree/livingMarkup/actions"><img src="https://github.com/hxtree/livingMarkup/workflows/CI/badge.svg" alt="CI Status"></a>
<a href="https://livingmarkup.readthedocs.io/en/latest/?badge=latest"><img src="https://readthedocs.org/projects/livingmarkup/badge/?version=latest" alt="Documentation Status"></a>
<a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/downloads" alt="Total Downloads"></a> <a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/v/stable" alt="Latest Stable Version"></a> 
<a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/license" alt="License"></a>
</p>

## About LivingMarkup
***LivingMarkup empowers teams to build dynamic web sites.*** It is a PHP implementation of a [LHTML5 processor](https://github.com/hxtree/lhtml5).

## Usage
Below is a simple example.

Page `/public/example.php`:
```PHP
<?php require 'vendor/autoload.php'; ?>
<body>
    <block name="UserProfile">
        <arg name="style" type="string">simple</arg>
        <p>Welcome <var name="first_name"/>!</p>
    </block>
</body>
```

Module `/modules/custom/Blocks/UserProfile.php`:
```php
<?php
namespace LivingMarkup\Modules\Custom\Blocks;

class UserProfile {

    public $first_name = 'Jane';
    
    public onRender() {
        return '<div class="user-profile ' . $this->getArgByName('style') . '">' . $this->xml . '</div>';
    }
}
```

Output `localhost/example`:
```html
<!DOCTYPE html>
<html lang="en">
    <body>
        <div class="user-profile simple">
            <p>Welcome Jane!</p>
        </div>
    </body>
</html>
```

## Installation

### Via Composer
LivingMarkup is available on [Packagist](https://packagist.org/packages/hxtree/livingMarkup).

Install with [Composer](https://getcomposer.org/download/):
```shell script
composer require hxtree/livingmarkup
# or git clone git@github.com:hxtree/LivingMarkup.git
```

Start with [Docker](https://docs.docker.com/get-docker/):
```shell script
sudo ./docker.sh start
# or setup an Apache2 webserver (reference Dockerfile for optimal settings)
```

View site with Browser
http://localhost

## Examples
Learn how LivingMarkup can be used through our [Examples](https://github.com/hxtree/LivingMarkup/blob/master/public/help/examples).

## Documentation
Check our docs for more info at [livingmarkup.readthedocs.io](https://livingmarkup.readthedocs.io).

## Contribute

Please refer to [CONTRIBUTING.md](https://github.com/hxtree/LivingMarkup/blob/master/.github/workflows/CONTRIBUTING.md) for 
information on how to contribute to LivingMarkup.

## Acknowledgments

Thanks to Aswin Vijayakumar for their useful comments that have led to changes to this implementation.