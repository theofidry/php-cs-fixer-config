# PHP-CS-Fixer Config

My personal PHP-CS-Fixer base configuration.


## Installation

```
$ composer require --dev theofidry/php-cs-fixer-config
```


### Usage

```php
<?php // php-cs-fixer.dist.php

declare(strict_types=1);

use Fidry\PhpCsFixerConfig\FidryConfig;
use PhpCsFixer\Finder;

$finder = // Configure Finder here as usual;

// Here use the specific config.
$config = new FidryConfig(
    // The header comment used
    <<<'EOF'
        This file is part of the Fidry PHP-CS-Fixer Config package.

        (c) Théo FIDRY <theo.fidry@gmail.com>

        For the full copyright and license information, please view the LICENSE
        file that was distributed with this source code.
        EOF,
    // The min PHP version supported (best to align with your composer.json)
    72000,
);

// You can further configure the $config here, to add or override some rules. 

return $config->setFinder($finder);
```
