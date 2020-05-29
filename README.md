<p align="center"><img src="https://github.com/hxtree/LivingMarkup/raw/master/assets/images/logo/434x100.jpg" width="400"></p>
 
A [LHTML processor](https://github.com/ouxsoft/LHTML) implementation in PHP.

<p align="center">
<a href="https://app.codacy.com/manual/hxtree/LivingMarkup?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=hxtree/LivingMarkup&amp;utm_campaign=Badge_Grade_Dashboard"><img src="https://api.codacy.com/project/badge/Grade/bfc76aaebde44a7fa239963e54883755" alt="Codacy Badge"></a>
<a href="https://github.com/hxtree/livingMarkup/actions"><img src="https://github.com/hxtree/livingMarkup/workflows/CI/badge.svg" alt="CI Status"></a>
<a href="https://livingmarkup.readthedocs.io/en/latest/?badge=latest"><img src="https://readthedocs.org/projects/livingmarkup/badge/?version=latest" alt="Documentation Status"></a>
<a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/downloads" alt="Total Downloads"></a> <a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/v/stable" alt="Latest Stable Version"></a> 
<a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/license" alt="License"></a>
</p>

## About
LivingMarkup is a customizable HTML templating engine that processes markup into objects and orchestrates them to build
dynamic markup. 

## Usage
```php
// instantiate Kernel
$kernel = new LivingMarkup\Kernel();

// instantiate Builder
$builder = new LivingMarkup\Builder\DynamicPageBuilder();

// load config
$config = new LivingMarkup\Configuration();

// add LHTML to config
$config->add('markup', '<html><block name="Messages"><arg name="amount" type="string">2</></block></html>');

// output Kernel build of Builder
echo $kernel->build($builder, $config);
```

## Installation

### Via Composer
LivingMarkup is available on [Packagist](https://packagist.org/packages/hxtree/livingMarkup).

Install with [Composer](https://getcomposer.org/download/):
```shell script
composer require ouxsoft/livingmarkup
```

Install with [Git](https://git-scm.com/):
```shell script
git clone git@github.com:ouxsoft/LivingMarkup.git
```

## Documentation
Check our docs for more info at [livingmarkup.readthedocs.io](https://livingmarkup.readthedocs.io).

## Contribute

Please refer to [CONTRIBUTING.md](https://github.com/hxtree/LivingMarkup/blob/master/.github/workflows/CONTRIBUTING.md) for 
information on how to contribute to LivingMarkup.

## Acknowledgments

Thanks to Aswin Vijayakumar for their useful comments that have led to changes to this implementation.