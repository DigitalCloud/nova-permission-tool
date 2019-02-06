# Nova Permission Tool.

This tool allows you to create and manage rules and permissions for nova resources. After installation, the default nova resource permissions will be generated for all available resources and resource actions.

# Requirements & Dependencies
This tool uses [Spatie Permission](https://github.com/spatie/laravel-permission) package.

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

To allow the tool to generate permissions actions, you need to se the name of the action. Actions with no names will not be generated automatically.

```php
<?php

namespace App\Nova\Actions;

use Laravel\Nova\Actions\Action;

class YourAction extends Action {
    
    // ...

    public $name = 'send email';
    
    // ...

}

```

and then in the resource you can authorize the action:

```php
<?php

namespace App\Nova;

use App\Nova\Actions\YourAction;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class Quotation extends Resource {
    
    // ...
    
    public function actions(Request $request) {
        return [
            (new YourAction())->canSee(function ($request) {
                return Gate::check('send email'); // the same name of the action
            })->canRun(function ($request) {
                return Gate::check('send email'); // the same name of the action
            })
        ];
    }
    
    // ...
}

```

## Images
![per](https://user-images.githubusercontent.com/41853913/50079673-e1971880-01f2-11e9-9e45-d9c0c7e1b861.PNG)
