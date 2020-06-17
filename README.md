Laravel Chained Jobs Shared Data
================================

![CI](https://github.com/renoki-co/laravel-chained-jobs-shared-data/workflows/CI/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/renoki-co/laravel-chained-jobs-shared-data/branch/master/graph/badge.svg)](https://codecov.io/gh/renoki-co/laravel-chained-jobs-shared-data/branch/master)
[![StyleCI](https://github.styleci.io/repos/273061597/shield?branch=master)](https://github.styleci.io/repos/273061597)
[![Latest Stable Version](https://poser.pugx.org/renoki-co/laravel-chained-jobs-shared-data/v/stable)](https://packagist.org/packages/renoki-co/laravel-chained-jobs-shared-data)
[![Total Downloads](https://poser.pugx.org/renoki-co/laravel-chained-jobs-shared-data/downloads)](https://packagist.org/packages/renoki-co/laravel-chained-jobs-shared-data)
[![Monthly Downloads](https://poser.pugx.org/renoki-co/laravel-chained-jobs-shared-data/d/monthly)](https://packagist.org/packages/renoki-co/laravel-chained-jobs-shared-data)
[![License](https://poser.pugx.org/renoki-co/laravel-chained-jobs-shared-data/license)](https://packagist.org/packages/renoki-co/laravel-chained-jobs-shared-data)

Chained Jobs Shared Data is a package that helps you distribute a data (usually an array) between chained jobs.

## 🚀 Installation

You can install the package via composer:

```bash
composer require renoki-co/laravel-chained-jobs-shared-data
```

## 🙌 Usage

You just have to replace the default job's `Dispatchable` and `Queueable` traits with the ones provided by this package.

``` php
// use Illuminate\Bus\Queueable;
// use Illuminate\Foundation\Bus\Dispatchable;
use RenokiCo\ChainedJobsSharedData\Traits\Dispatchable;
use RenokiCo\ChainedJobsSharedData\Traits\Queueable;

class MyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // the rest of job here
}
```

## 🐛 Testing

``` bash
vendor/bin/phpunit
```

## 🤝 Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 🔒  Security

If you discover any security related issues, please email alex@renoki.org instead of using the issue tracker.

## 🎉 Credits

- [Alex Renoki](https://github.com/rennokki)
- [All Contributors](../../contributors)

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
