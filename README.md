<p align="center">
    <img src="https://raw.githubusercontent.com/akki-io/cron-expression-generator/master/hero.png" alt="Hero" width="600">
</p>

# Cron Expression Generator

[![Latest Version](https://img.shields.io/github/release/akki-io/cron-expression-generator.svg?style=flat-square)](https://github.com/akki-io/cron-expression-generator/releases)
[![Build Status](https://img.shields.io/travis/akki-io/cron-expression-generator/master.svg?style=flat-square)](https://travis-ci.com/akki-io/cron-expression-generator)
[![Quality Score](https://img.shields.io/scrutinizer/g/akki-io/cron-expression-generator.svg?style=flat-square)](https://scrutinizer-ci.com/g/akki-io/cron-expression-generator)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/371128023/shield?branch=master)](https://styleci.io/repos/371128023)
[![Total Downloads](https://img.shields.io/packagist/dt/akki-io/cron-expression-generator.svg?style=flat-square)](https://packagist.org/packages/akki-io/cron-expression-generator)

Generate cron expressions based on user inputs. 

## Installation

You can install the package via composer:

```bash
composer require akki-io/cron-expression-generator
```

## Introduction

A CRON expression is a string representing the schedule for a particular command to execute. 
The parts of a CRON schedule are as follows:

```shell
*    *    *    *    *
-    -    -    -    -
|    |    |    |    |
|    |    |    |    |
|    |    |    |    +----- day of week (0 - 6) (Sunday=0)
|    |    |    +---------- month (1 - 12)
|    |    +--------------- day of month (1 - 31)
|    +-------------------- hour (0 - 23)
+------------------------- min (0 - 59)
```

| Cron Schedule | Package Request Mapping |
| ----------- | ----------- |
| min | minute |
| hour | hour |
| day of month | day_month |
| month | month |
| day of week | day_week |


This package supports the following different options for each schedule. 

| Option Type (*required) | Description | Nested Required Parameters |
| ----------- | ----------- | ----------- |
| ONCE | Generate cron once | int `at`, b/t the range of schedule |
| EVERY | Generate cron for every | int `every`, b/t the range of schedule |
| LIST | Generate cron based on the list of values | array `list` and int `list.*`, b/t the range of schedule |
| RANGE | Generate cron based on range | int `start` and int `end` both b/t the range of schedule |
| STEP | Generate cron based on step | int `every`, int `start` and int `end` all b/t the range of schedule |


## Usage

You can set the `$options` array below based on the different options as outlined above.

```php
    use AkkiIo\CronExpressionGenerator\CronExpressionGenerator;

    $options = [];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
```

## Examples

**Generate cron expression for every minute**

```php
    $options = [];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
      
    // * * * * *
```

**Generate cron expression for once every hour**

```php
    $options = [
        'minute' => [
            'type' => 'ONCE',
            'at' => 0,
        ],
        'hour' => [
            'type' => 'EVERY',
            'every' => 1,
        ],
    ];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
    
    // 0 */1 * * *
```

**Generate cron expression for once every day at 10:15 AM**

```php
    $options = [
        'minute' => [
            'type' => 'ONCE',
            'at' => 15,
        ],
        'hour' => [
            'type' => 'ONCE',
            'at' => 10,
        ],
    ];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
    
    // 15 10 * * *
```

**Generate cron expression for once every weekday at 10:15 AM**

```php
    $options = [
        'minute' => [
            'type' => 'ONCE',
            'at' => 15,
        ],
        'hour' => [
            'type' => 'ONCE',
            'at' => 10,
        ],
        'day_week' => [
            'type' => 'RANGE',
            'start' => 1,
            'end' => 5,
        ],
    ];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
    
    // 15 10 * * 1-5
```

**Generate cron expression for once every month of day 22 at 10:15 AM**

```php
    $options = [
        'minute' => [
            'type' => 'ONCE',
            'at' => 15,
        ],
        'hour' => [
            'type' => 'ONCE',
            'at' => 10,
        ],
        'day_month' => [
            'type' => 'ONCE',
            'at' => 22,
        ],
    ];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
      
    // 15 10 22 * *
```

**Generate cron expression for every Sunday at 10:15 AM**

```php
    $options = [
        'minute' => [
            'type' => 'ONCE',
            'at' => 15,
        ],
        'hour' => [
            'type' => 'ONCE',
            'at' => 10,
        ],
        'day_week' => [
            'type' => 'ONCE',
            'at' => 0,
        ],
    ];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
      
    // 15 10 * * 0
```

**Generate cron expression for every year on Oct 22 at 10:15 AM**

```php
    $options = [
        'minute' => [
            'type' => 'ONCE',
            'at' => 15
        ],
        'hour' => [
            'type' => 'ONCE',
            'at' => 10,
        ],
        'day_month' => [
            'type' => 'ONCE',
            'at' => 22,
        ],
        'month' => [
            'type' => 'ONCE',
            'at' => 10,
        ],
    ];

    $cronExpression = (new CronExpressionGenerator($options))->generate();
      
    // 15 10 22 10 *
```

### Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email hello@akki.io instead of using the issue tracker.

## Credits

-   [Akki Khare](https://github.com/akki-io)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
