<p align="center"><img src="https://github.com/hxtree/LivingMarkup/raw/master/assets/images/logo/434x100.jpg" width="400"></p>

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bfc76aaebde44a7fa239963e54883755)](https://app.codacy.com/manual/hxtree/LivingMarkup?utm_source=github.com&utm_medium=referral&utm_content=hxtree/LivingMarkup&utm_campaign=Badge_Grade_Dashboard)
[![CI Status](https://github.com/hxtree/livingMarkup/workflows/CI/badge.svg)](https://github.com/hxtree/livingMarkup/actions)
[![Documentation Status](https://readthedocs.org/projects/livingmarkup/badge/?version=latest)](https://livingmarkup.readthedocs.io/en/latest/?badge=latest)
[![Total Downloads](https://poser.pugx.org/hxtree/livingmarkup/downloads)](https://packagist.org/packages/hxtree/livingmarkup) [![Latest Stable Version](https://poser.pugx.org/hxtree/livingmarkup/v/stable)](https://packagist.org/packages/hxtree/livingmarkup) 
[![License](https://poser.pugx.org/hxtree/livingmarkup/license)](https://packagist.org/packages/hxtree/livingmarkup)

## About LivingMarkup
***LivingMarkup is an PHP implementation of a LHTML5 parser.*** It is a powerful and flexible way to build dynamic web pages.

## Usage

LHTML5
```PHP
<?php require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php'; ?>
<body>
    <block name="UserProfile">
        <arg name="style">simple</arg>
        <p>Welcome <var name="first_name"/>!</p>
    </block>
</body>
```
HTML5
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

Install with Composer:
```shell script
composer require hxtree/livingmarkup
```

## Examples
Learn how LivingMarkup can be used through our [Examples](https://github.com/hxtree/LivingMarkup/blob/master/examples/README.md).

## Documentation
Check our docs for more info at [livingmarkup.readthedocs.io](https://livingmarkup.readthedocs.io)

## Contribute

Please refer to [CONTRIBUTING.md](https://github.com/hxtree/LivingMarkup/blob/master/.github/workflows/CONTRIBUTING.md) for 
information on how to contribute to LivingMarkup.