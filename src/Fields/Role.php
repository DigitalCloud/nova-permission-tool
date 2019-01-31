<?php

namespace DigitalCloud\PermissionTool\Fields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Role extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'role';

    /**
     * The URI key of the related resource.
     *
     * @var string
     */
    public $resourceName;

    /**
     * The displayable singular label of the relation.
     *
     * @var string
     */
    public $singularLabel;

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->options();
    }

    public function options() {
        return $this->withMeta([
            'options' => \DigitalCloud\PermissionTool\Models\Role::get()->map(function ($role) {
                return [
                    'display' => $role->name,
                    'value' => $role->id,
                    'permissions' => $role->permissions()->get()->map(function ($permission) {
                        return [
                            'display' => $permission->name,
                            'value' => $permission->id,
                            'resource' => substr($permission->name, strrpos($permission->name, ' ') + 1)
                        ];
                    })
                ];
            })->values()->all(),
        ]);

    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute) {
        if ($request->exists($requestAttribute)) {
            $data = json_decode($request[$requestAttribute]);
            $value = $this->onlyChecked($data);
            $model->{$attribute} = $value;
        }
    }

    public function resolveAttribute($resource, $attribute = null) {
        $value = data_get($resource, $attribute);

        if(! $value) return json_encode($this->withUnchecked([]));

        return json_encode($this->withUnchecked($value->toArray()));
    }

    private function withUnchecked($data) {
        return collect($this->meta['options'])
            ->mapWithKeys(function($option) use ($data){
                $value = array_filter($data, function($item) use ($option) { return $option['value'] == $item['id'];});
                $isChecked = $value? true : false;
                return [ $option['value'] => $isChecked ];
            })->all();
    }

    private function onlyChecked($data) {
        return collect($data)
            ->filter(function($isChecked){
                return $isChecked;
            })->map(function($value, $key){
                return $key;
            })->values()->all();
    }

}
