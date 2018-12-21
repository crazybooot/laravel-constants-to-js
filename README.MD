# Exports Laravel config and class constants to JavaScript


Includes artisan command to generate JavaScript ES6 or UMD module
## Installation

You can install the package via composer:

```bash
composer require crazybooot/laravel-constants-to-js
```

## Usage
Add JavaScript resulted object hierarchy to `config\constants-to-js.php` config
file to `constants` section as an assoc array.

To include constants from specified class use `class` as key and class 
name as value:

```php
return [
    'constants' => [
        'user' => [
            'type' => [
                'class' => App\User::class,
            ],
        ],
    ],
];
```

To inculde values from config file use `config` as key and string with
path to config as value:

```php
return [
    'constants' => [
        'queue' => [
            'connections' => [
                'config' => 'queue.connections',
            ],
        ],
    ],
];
```

Including class constants supports to filter them by constant name using `starts_with` option:
```php
return [
    'constants' => [
        'user' => [
            'type'   => [
                'class'       => App\User::class,
                'starts_with' => 'TYPE_',
            ],
            'status' => [
                'class'       => App\User::class,
                'starts_with' => 'STATUS_',  
            ],
        ],
    ],
];
```

To make some transformation with kyes and values use `transform_key` or `transform_value` options array
where each key is a function will be applied to key or value and its value is array of additional parameters
which will be passed to function:
 as value
 
```php
return [
    'constants' => [
        'user' => [
            'type'   => [
                'class'       => App\User::class,
                'transform_key' => [
                    'strtoupper' => [],
                ]
            ],
        ],
        'queue' => [
            'connections' => [
                'config' => 'queue.connections',
                'transform_value' => [
                    'array_get'  => ['driver'],
                    'title_case' => []
                ],
            ],
        ],
    ],
];
```

To change destination and generated JavaScript file name use `target_path`
configuration option:
```php
return [
    'target_path' => resource_path('assets/js/constants.js'),
];
```


After cofiguration run next command to generate resulted JavaScript file:
``` bash
php artisan constants:js
```
