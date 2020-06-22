<p align="center"><img src="https://github.com/ouxsoft/LivingMarkup/raw/master/assets/images/logo/434x100.jpg" width="400"></p>
 
<p align="center">
A <a href="https://github.com/ouxsoft/LHTML">LHTML processor</a> implementation in PHP.
</p>

<p align="center">
<a href="https://packagist.org/packages/ouxsoft/livingmarkup"><img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/ouxsoft/livingmarkup"></a> <a href="https://travis-ci.com/github/ouxsoft/LivingMarkup"><img src="https://api.travis-ci.com/ouxsoft/LivingMarkup.svg?branch=master&status=passed" alt="Build Status"></a> <a href="https://github.com/ouxsoft/livingMarkup/actions"><img alt="GitHub Workflow Status" src="https://img.shields.io/github/workflow/status/ouxsoft/livingmarkup/CI"></a> <a href="https://livingmarkup.readthedocs.io/en/latest/?badge=latest"><img src="https://readthedocs.org/projects/livingmarkup/badge/?version=latest" alt="Documentation Status"></a> <a href="https://app.codacy.com/gh/ouxsoft/LivingMarkup?utm_source=github.com&utm_medium=referral&utm_content=ouxsoft/LivingMarkup&utm_campaign=Badge_Grade_Dashboard"><img alt="Codacy grade" src="https://img.shields.io/codacy/grade/86210d48e2ca45e497be865ace8a4029"></a> <a href="https://codecov.io/gh/ouxsoft/LivingMarkup"> <img alt="Codecov" src="https://img.shields.io/codecov/c/github/ouxsoft/livingmarkup"> </a> <a href="https://packagist.org/packages/ouxsoft/livingmarkup"><img src="https://poser.pugx.org/ouxsoft/livingmarkup/downloads" alt="Total Downloads"></a>
 
</p>

## About

LivingMarkup is a HTML templating engine that orchestrates customizable Elements to build dynamic markup.

## Usage
Here we'll add an abstraction layer to make major Bootstrap upgrades easy.
 
Start by creating an LHTML Element:
```php
namespace Partial;

class Alert extends LivingMarkup\Element\AbstractElement 
{
    public function onRender()
    {
        switch($this->getArgByName('type')){
            case 'success':
                $class = 'alert-success;
                break;
            case 'warning':
                $class = 'alert-warning';
                break;
            default:
                $class = 'alert-info';
                break;
        }
        return "<div class=\"alert {$class}\" role=\"alert\">{$this->innerText()}</div>";
    }
}
```

Then add the LHTML Element to a LHTML processor: 
```php
// instantiate processor
$proc = new LivingMarkup\Processor();

// add LHTML Element to processor
$proc->addElement('Partial', '//partial', 'Partial\{name}');

// automate method call
$proc->addMethod('onRender','Execute for render', 'RETURN_CALL');

// process LHTML string
echo $proc->parseString('<html>
    <partial name="Alert" type="success">This is a success alert.</partial>
</html>');
```


## Installation

### Via Composer
LivingMarkup is available on [Packagist](https://packagist.org/packages/ouxsoft/livingMarkup).

Install with [Composer](https://getcomposer.org/download/):
```shell script
composer require ouxsoft/livingmarkup
```

Install with [Git](https://git-scm.com/):
```shell script
git clone git@github.com:ouxsoft/LivingMarkup.git
```

LivingMarkup comes packaged with only LHTML test Elements. For core Elements, see:
 * [Hoopless](https://github.com/ouxsoft/hoopless)

## Documentation
Check our docs for more info at [livingmarkup.readthedocs.io](https://livingmarkup.readthedocs.io).

## Contribute

Refer to [CONTRIBUTING.md](https://github.com/ouxsoft/LivingMarkup/blob/master/.github/workflows/CONTRIBUTING.md) for 
information on how to contribute.


## Creators

***Matthew Heroux***

  * [https://github.com/hxtree](https://github.com/hxtree)

## Acknowledgement

Thanks to Aswin Vijayakumar for their useful comments that have led to changes to this implementation.
