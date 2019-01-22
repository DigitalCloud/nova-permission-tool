<?php

namespace DigitalCloud\PermissionTool\Resources;

use App\Rules\HasPermission;
use DigitalCloud\CheckboxList\CheckboxList;
use Fourstacks\NovaCheckboxes\Checkboxes;
use Laravel\Nova\Nova;
use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\BelongsToMany;
use Spatie\Permission\PermissionRegistrar;

class Role extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DigitalCloud\PermissionTool\Models\Role::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    public static $displayInNavigation = false;

    public static function getModel()
    {
        return app(PermissionRegistrar::class)->getRoleClass();
    }

    public static function label()
    {
        return __('PermissionTool::resources.Roles');
    }

    public static function singularLabel()
    {
        return __('PermissionTool::resources.Role');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name));

        foreach (Nova::$resources as $resource) {
            if($resource == 'Laravel\Nova\Actions\ActionResource') {
                continue;
            }
            $resourceName = strtolower(substr(strrchr($resource, "\\"), 1));
            $resourcePermissions = [
                "viewAny $resourceName"         => "viewAny $resourceName",
                "create $resourceName"          => "create $resourceName",
                "update $resourceName"          => "update $resourceName",
                "view $resourceName"            => "view $resourceName",
                "delete $resourceName"          => "delete $resourceName",
                "force delete $resourceName"    => "force delete $resourceName",
                "restore $resourceName"         => "restore $resourceName",
                "attach $resourceName"          => "attach $resourceName",
                "detach $resourceName"          => "detach $resourceName"
            ];
            foreach ($resourcePermissions as $resourcePermission) {
                $dbPermision = \DigitalCloud\PermissionTool\Models\Permission::firstOrCreate(
                    ['name' => $resourcePermission], ['guard_name' => 'web']
                );
            }
        }

        $fields =  [
            ID::make()->sortable(),

            Text::make(__('PermissionTool::roles.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.roles'))
                ->updateRules('unique:'.config('permission.table_names.roles').',name,{{resourceId}}'),

            \DigitalCloud\PermissionTool\Fields\Permission::make(__('PermissionTool::resources.Permissions'), 'permissions')->onlyOnForms(),

            Text::make('permissions count')->withMeta(['value' => count($this->permissions)])->exceptOnForms(),
            Text::make('users count')->withMeta(['value' => count($this->users)])->exceptOnForms(),
            DateTime::make(__('PermissionTool::roles.created_at'), 'created_at')->exceptOnForms(),
            DateTime::make(__('PermissionTool::roles.updated_at'), 'updated_at')->exceptOnForms(),

            BelongsToMany::make(__('PermissionTool::resources.Permissions'), 'permissions', Permission::class),
            MorphToMany::make($userResource::label(), 'users', $userResource),


        ];

        return $fields;
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }


//    public function authorizedToDelete(Request $request)
//    {
//        return false;
//    }
//
//    public function authorizedToUpdate(Request $request)
//    {
//        return ($this->id == 1)? false : true;
//    }
}
