<!-- vim:set filetype=php <?php -->

[![Latest Stable Version](https://poser.pugx.org/traimmu/mf-cloud-invoice/v/stable)](https://packagist.org/packages/traimmu/mf-cloud-invoice)
[![Latest Unstable Version](https://poser.pugx.org/traimmu/mf-cloud-invoice/v/unstable)](https://packagist.org/packages/traimmu/mf-cloud-invoice)
[![License](https://poser.pugx.org/traimmu/mf-cloud-invoice/license)](https://packagist.org/packages/traimmu/mf-cloud-invoice)
[![Monthly Downloads](https://poser.pugx.org/traimmu/mf-cloud-invoice/d/monthly)](https://packagist.org/packages/traimmu/mf-cloud-invoice)
[![CircleCI](https://circleci.com/gh/Traimmu/mf-cloud-invoice-php.svg?style=svg)](https://circleci.com/gh/Traimmu/mf-cloud-invoice-php)

# mf_cloud-invoice-php

[MFクラウド請求書API](https://github.com/moneyforward/invoice-api-doc) client library for PHP

This library is inspired by [moneyforward/mf_cloud-invoice-ruby](https://github.com/moneyforward/mf_cloud-invoice-ruby)

# ready
```
composer config repositories.grkztd/mf-cloud-invoice github https://github.com/grkztd/mf-cloud-invoice
```

# Installation

```
composer require grkztd/mf-cloud-invoice
```

# MF側

## アプリの作成

scope
```
mfc/admin/office.read
mfc/invoice/data.read
```
## ブラウザで認可エンドポイントにアクセス(認可コードを使ってアクセストークンを取得) 
```
https://api.biz.moneyforward.com/authorize?
	response_type=code&
	client_id=${ClientID}&
	scope=mfc/invoice/data.read&
	redirect_uri=http://localhost:12345/callback
```
```
https://api.biz.moneyforward.com/authorize?response_type=code&client_id=115551763027692&scope=mfc/invoice/data.read&redirect_uri=http://127.0.0.1:8082/oauth/callback
```
```
array:5 [▼ // routes/web.php:56
  "access_token" => "H6bOL_Q1PP6nNbk4-RUv9kJI638tkPT-DI0ZHb0ubyE"
  "refresh_token" => "W9nc9zKu1WnBaAve5PQ2wWHOb4eUNg9F3PIC04r2R9Q"
  "scope" => "mfc/invoice/data.read"
  "token_type" => "Bearer"
  "expires_in" => 3600
]
```
※expires_inは秒？
## ブラウザで認可エンドポイントにアクセス(リフレッシュトークンを利用してアクセストークンを再発行する) 
```
https://api.biz.moneyforward.com/authorize?
	response_type=code&
	client_id=${ClientID}&
	scope=mfc/invoice/data.read&
	redirect_uri=http://localhost:12345/callback
```
# Usage

## Build client

```php
use Traimmu\MfCloud\Invoice\Client;

$client = new Client('YOUR_ACCESS_TOKEN');

$client->billings()->all();
// => your billings
```

## Get My Office

```php
$office = $client->office(); // => returns Traimmu\MfCloud\Invoice\Models\Office instance
echo $office->name; // => '株式会社Traimmu'

$office->update([
    'name' => 'section9',
    'zip' => '101-1111',
]);
echo $office->name; // => 'section9'
```

### Get Partners

```php
$client->partners()->all();
$client->partners()->find('MF INVOICE PARTNER ID');
```

### Get Billings

```php
$client->billings()->all();
```

### Items

```php
$client->items()->all();
```

<!-- ## Errors -->

# Laravel Integration

Add the `Traimmu\MfCloud\Invoice\Misc\ServiceProvider` provider to the `providers` array in `config/app.php`:

```php
'providers' => [
    // ...
    Traimmu\MfCloud\Invoice\Misc\ServiceProvider::class,
],
```

Then add the facade to your `aliases` array:

```php
'aliases' => [
    // ...
    'Invoice' => Traimmu\MfCloud\Invoice\Misc\Facade::class,
],
```

Finally, add the following lines at `config/services.php`:

```php
// ...
'mfcloud' => [
    'secret' => env('MFCLOUD_INVOICE_API_TOKEN'),
],
```

# Example

Get partners which have more than one departments:

```php
<?php
$client->partners()->all()->filter(function ($partner) {
  return count($partner->departments) > 0;
});
```

# Loadmap

- [ ] Add tests
  - [x] client
  - [ ] api
  - [ ] models
- [x] Add service provider for Laravel
- [ ] Add Eloquent model like methods and relationships
  - [x] api->firstOrCreate()
  - [ ] Create Department model
  - [ ] `$client->partners()->first()->departments()->create($params)`
  - [ ] `$client->partners()->first()->departments->first()`
  - [ ] Partner hasMany Departments
  - [ ] Department hasMany Billings
  - [ ] Billing hasMany Items
- [ ] Add Exceptions
- [ ] Add circle.yml and build automatically
- [ ] Add more documents
- [ ] Add authentication for getting OAuth token

# Development

After checking out the repo, run `composer install` to install dependencies.

Then run `vendor/bin/phpunit` and ensure all tests success.

# Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/Traimmu/mf_cloud-invoice-php

# License

The package is available as open source under the terms of the [MIT License](http://opensource.org/licenses/MIT).


