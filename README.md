<p align="center"><img src="https://github.com/hxtree/LivingMarkup/raw/master/assets/images/logo/434x100.jpg" width="400"></p>
 
<p align="center">
A <a href="https://github.com/ouxsoft/LHTML">LHTML processor</a> implementation in PHP.
</p>

<p align="center">
<a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/v/stable" alt="Latest Stable Version"></a> 
<a href="https://travis-ci.org/github/ouxsoft/LivingMarkup"><img src="https://travis-ci.org/ouxsoft/LivingMarkup.svg?branch=master" alt="Build Status"></a>
<a href="https://github.com/hxtree/livingMarkup/actions"><img src="https://github.com/hxtree/livingMarkup/workflows/CI/badge.svg" alt="CI Status"></a>
<a href="https://livingmarkup.readthedocs.io/en/latest/?badge=latest"><img src="https://readthedocs.org/projects/livingmarkup/badge/?version=latest" alt="Documentation Status"></a>
<a href="https://app.codacy.com/manual/hxtree/LivingMarkup?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=hxtree/LivingMarkup&amp;utm_campaign=Badge_Grade_Dashboard"><img src="https://api.codacy.com/project/badge/Grade/bfc76aaebde44a7fa239963e54883755" alt="Codacy Badge"></a>
<a href='https://coveralls.io/github/ouxsoft/LivingMarkup?branch=%28HEAD+detached+at+3e5988b%29'><img src='https://coveralls.io/repos/github/ouxsoft/LivingMarkup/badge.svg?branch=%28HEAD+detached+at+3e5988b%29' alt='Coverage Status' /></a>
<a href="https://packagist.org/packages/hxtree/livingmarkup"><img src="https://poser.pugx.org/hxtree/livingmarkup/downloads" alt="Total Downloads"></a> 
</p>

## About
LivingMarkup is a customizable HTML templating engine that processes markup into objects and orchestrates them to build
dynamic markup. 

## Usage
Let's say we want to add an abstraction layer to make not backwards compatible Bootstrap future upgrades easy.
 
Create an LHTML Module:
```php
namespace Partial;

class Alert extends LivingMarkup\Module {
    public function onRender(){
        $type = $this->getArgByName('type');
        switch($type){
            case 'success':
                $class = 'alert-success;
'               break;
            case 'warning':
                $class = 'alert-warning';
                break;
            default:
                $class = 'alert-info';
                break;
        }
        return '<div class="alert ' . $class . '" role="alert">' . 
            $this->innerText() .
        '</div>';
    }
}
```

Add custom module to LHTML processor: 
```php
// instantiate processor
$proc = new LivingMarkup\Processor();

// add object to processor
$proc->addObject('Partial', '//partial', 'Partial\{name}');

// automate method call
$proc->addMethod('onRender','Execute for render', 'RETURN_CALL');

// process LHTML string
echo $proc->parseString('<html>
    <partial name="Alert" type="success">This is a success alert.</partial>
</html>');

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

## Acknowledgement

Thanks to Aswin Vijayakumar for their useful comments that have led to changes to this implementation.
