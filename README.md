![alt text](https://github.com/hxtree/LivingMarkup/raw/master/docs/logo/392x100.jpg "LivingMarkup")

***LivingMarkup is an PHP implementation of a Living Hypertext Markup Language (LHTML) parser.*** 
It instantiates DomElements as customizable backend components and orchestrates methods calls to build dynamic HTML.

[![Latest Stable Version](https://img.shields.io/packagist/v/hxtree/livingMarkup.svg?style=flat-square)](https://packagist.org/packages/hxtree/livingMarkup)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?style=flat-square)](https://php.net/)
[![CI Status](https://github.com/hxtree/livingMarkup/workflows/CI/badge.svg)](https://github.com/hxtree/livingMarkup/actions)
[![Documentation Status](https://readthedocs.org/projects/livingMarkup/badge/?version=latest)](https://livingMarkup.readthedocs.io/en/latest/?badge=latest)
![GitHub issues](https://img.shields.io/github/issues/hxtree/livingMarkup)
![GitHub](https://img.shields.io/github/license/hxtree/livingMarkup)
[![Help Wanted!](https://img.shields.io/badge/help-wanted-brightgreen.svg?style=flat "Please Help Us")](https://github.com/hxtree/LivingMarkup/blob/master/.github/workflows/CONTRIBUTING.md)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://paypal.me/hxtree)

LHTML
```
<body>
    <partial name="userprofile">
        <p><var name="username"/></p>
    </partial>
</body>
```
HTML
```
<body>
    <div class="user-profile">
        <p>Jane Doe</p>
    </div>
</body>
```

# Installation

## Via Composer
LivingMarkup is available on [Packagist](https://packagist.org/packages/hxtree/livingMarkup).

Install with Composer:
```shell script
$ composer require hxtree/livingMarkup
```

# Examples
Learn how LivingMarkup can be used through our [Examples](https://github.com/hxtree/LivingMarkup/blob/master/examples/README.md).

# Documentation
Check our docs for more info at [livingMarkup.readthedocs.io](https://livingMarkup.readthedocs.io)

# Contribute

Please refer to [CONTRIBUTING.md](https://github.com/hxtree/LivingMarkup/blob/master/.github/workflows/CONTRIBUTING.md) for 
information on how to contribute to LivingMarkup.