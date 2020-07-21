# Markdown Package

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/rancoud/markdown)
[![Packagist Version](https://img.shields.io/packagist/v/rancoud/markdown)](https://packagist.org/packages/rancoud/markdown)
[![Packagist Downloads](https://img.shields.io/packagist/dt/rancoud/markdown)](https://packagist.org/packages/rancoud/markdown)
[![Composer dependencies](https://img.shields.io/badge/dependencies-0-brightgreen)](https://github.com/rancoud/markdown/blob/master/composer.json)
[![Test workflow](https://img.shields.io/github/workflow/status/rancoud/markdown/test?label=test&logo=github)](https://github.com/rancoud/markdown/actions?workflow=test)
[![Codecov](https://img.shields.io/codecov/c/github/rancoud/markdown?logo=codecov)](https://codecov.io/gh/rancoud/markdown)
[![composer.lock](https://poser.pugx.org/rancoud/markdown/composerlock)](https://packagist.org/packages/rancoud/markdown)

Markdown using [GitHub Flavored Markdown Spec](https://github.github.com/gfm/#what-is-github-flavored-markdown-).  

## Installation
```php
composer require rancoud/markdown
```

## How to use it?
```php
$m = new \Rancoud\Markdown\Markdown();
echo $m->render('*my content*');
```

## Markdown Methods
### General Commands  
* render(content: string):string

## How to Dev
`composer ci` for php-cs-fixer and phpunit and coverage  
`composer lint` for php-cs-fixer  
`composer test` for phpunit and coverage
