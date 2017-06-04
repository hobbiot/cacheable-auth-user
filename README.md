# cacheable-auth-user
[![Latest Stable Version](https://poser.pugx.org/hobbiot/cacheable-auth-user/v/stable)](https://packagist.org/packages/hobbiot/cacheable-auth-user) [![Total Downloads](https://poser.pugx.org/hobbiot/cacheable-auth-user/downloads)](https://packagist.org/packages/hobbiot/cacheable-auth-user) [![Latest Unstable Version](https://poser.pugx.org/hobbiot/cacheable-auth-user/v/unstable)](https://packagist.org/packages/hobbiot/cacheable-auth-user) [![License](https://poser.pugx.org/hobbiot/cacheable-auth-user/license)](https://packagist.org/packages/hobbiot/cacheable-auth-user)

  Cacheable Auth::user() for Laravel 5.3 or 5.4.

## Installation
Composer  
```terminal
composer require hobbiot/cacheable-auth-user
```

### Laravel
#### app.php
In your `config/app.php` add `HobbIoT\Auth\CacheableAuthUserServiceProvider::class` to the end of the `providers` array:

```php
'providers' => [
    ...
        HobbIoT\Auth\CacheableAuthUserServiceProvider::class,
    ...
],
```

#### auth.php
In your `config/auth.php` change User Providers' driver. You can now use "__cacheableEloquent__".

```php
...
    'providers' => [
        'users' => [
            'driver' => 'cacheableEloquent',
            'model' => App\User::class,
        ],
		// e.g.
        'admin' => [
            'driver' => 'cacheableEloquent',
            'model' => App\Administrator::class,
        ],
    ],
...
],
```
Administrator::class needs to extend Authenticatable (Illuminate\\Foundation\\Auth\\User)  and use trait Notifiable (Illuminate\\Notifications\\Notifiable), just like App\\User::class.

### Supplementary Explanation
* The cache is valid for 60 minutes.
* The cache Key is _ModelClassName_\_By\_Id\__id_ and _ModelClassName_\_By\_Id\_Token\__id_.
* Using Eloquent _updated_ event listener to clear cache, need to use `model->save()`. When user update his name in profile page,
 fire _updated_ event automatically, (listen event and) clear cache. After that reload from resources (database).

  Laravel Official Documentation said,
>Note: When issuing a mass update via Eloquent, the _saved_ and _updated_ model events will not be fired for the updated models. This is because the models are never actually retrieved when issuing a mass update.
