# Nova Permission Tool.

This tool allows you to create and manage rules and permissions for nova resources.

## Installation

You can install the package via composer:

```bash
composer require digitalcloud/nova-permission-tool
```

You can publish the migration with:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
```

After the migration has been published you can create the role- and permission-tables by running the migrations:

```bash
php artisan migrate
```

## Usage

You must register the tool with Nova. This is typically done in the tools method of the NovaServiceProvider, in app/Providers/NovaServiceProvider.php.

```php

use DigitalCloud\PermissionTool\PermissionTool;
// ....

public function tools()
{
    return [
        // ...
        new PermissionTool(),
        // ...
    ];
}

```

## Images
![per](https://user-images.githubusercontent.com/41853913/50079673-e1971880-01f2-11e9-9e45-d9c0c7e1b861.PNG)
