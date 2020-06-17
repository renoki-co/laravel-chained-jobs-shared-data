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

## Use Case

The main use case is to share some data between chained jobs, while being able to modify it and be retrieved in the next jobs with the previous modifications.

```php
CreateUser::withChain([
    new CreateApiKey,
    new MakeTestApiCall,
])->dispatch();
```

The `CreateApiKey` and `MakeTestApiCall` are the jobs that depend by the `CreateUser` at glance.

Without using this package's traits, the only workaround would be to trigger the ```CreateApiKey``` in the `CreateUser` job, then trigger the next one, and the next one, etc. and you will end up bad code to manage and troubleshoot.

If all job classes use the previous mentioned traits, having some shared data is going to ease the job:

```php
// CreateUser.php

public function handle()
{
    $user = $this->createUser();

    $this->sharedData['user'] = $user;
}
```

```php
// CreateApiKey.php

public function handle()
{
    $apiKey = $this->createApiKeyForUser($this->sharedData['user']);

    $this->sharedData['api_key'] = $apiKey;
}
```

```php
// MakeTestApiCall.php

public function handle()
{
    $this->makeApiCall(
        $this->sharedData['user'],
        $this->sharedData['api_key'],
    );
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
