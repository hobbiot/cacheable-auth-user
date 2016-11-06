# cacheable-auth-user
cached Auth::user() for Laravel 5.3

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

If Lumen

```php
$app->register(HobbIoT\Auth\CacheableAuthUserServiceProvider::class);
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
