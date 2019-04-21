<?php

namespace DigitalCloud\PermissionTool\Resources;

use Laravel\Nova\Nova;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\BelongsToMany;
use Spatie\Permission\PermissionRegistrar;

class Permission extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DigitalCloud\PermissionTool\Models\Permission::class;

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
        return app(PermissionRegistrar::class)->getPermissionClass();
    }

    public static function label()
    {
        return __('PermissionTool::resources.Permissions');
    }

    public static function singularLabel()
    {
        return __('PermissionTool::resources.Permission');
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

        return [
            ID::make()->sortable(),

            Text::make(__('PermissionTool::permissions.name'), 'name')
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:'.config('permission.table_names.permissions'))
                ->updateRules('unique:'.config('permission.table_names.permissions').',name,{{resourceId}}'),

            Text::make(__('PermissionTool::permissions.display_name'), function () {
                return __('PermissionTool::permissions.display_names.'.$this->name);
            })->canSee(function () {
                return is_array(__('PermissionTool::permissions.display_names'));
            }),

            DateTime::make(__('PermissionTool::permissions.created_at'), 'created_at')->exceptOnForms(),
            DateTime::make(__('PermissionTool::permissions.updated_at'), 'updated_at')->exceptOnForms(),

            BelongsToMany::make(__('PermissionTool::resources.Roles'), 'roles', Role::class)->searchable(),
            MorphToMany::make($userResource::label(), 'users', $userResource)->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }


    public static function relatableQuery(NovaRequest $request, $query)
    {
        $role = \DigitalCloud\PermissionTool\Models\Role::find($request->route('resourceId'));
        //dd($role->permissions()->pluck('permission_id'));
        return $query->whereNotIn('id', $role->permissions()->pluck('permission_id'));
        return parent::relatableQuery($request, $query);
    }

}
