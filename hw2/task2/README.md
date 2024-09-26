# Colorized CLI Tool

Colorized CLI tool helps to colorize CLI outputs

## Requirements

* php >= 5.4.0

## Install

```
composer require jekys/console
```

## Usage
```
require_once 'vendor/autoload.php';

use Jekys\Console;

Console::text('This is a simple text');
Console::notify('This is a notify text');
Console::error('This is an error text');
Console::success('This is a success text');
```