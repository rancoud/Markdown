# Markdown Package

[![Build Status](https://travis-ci.org/rancoud/Markdown.svg?branch=master)](https://travis-ci.org/rancoud/Markdown) [![Coverage Status](https://coveralls.io/repos/github/rancoud/Markdown/badge.svg?branch=master)](https://coveralls.io/github/rancoud/Markdown?branch=master)

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
`./run_all_commands.sh` for php-cs-fixer and phpunit and coverage  
`./run_php_unit_coverage.sh` for phpunit and coverage  