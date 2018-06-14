<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Filters;

use Orchid\Screen\Fields\Field;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class RoleFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'role',
    ];

    /**
     * @var bool
     */
    public $display = true;

    /**
     * @var bool
     */
    public $dashboard = true;

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->whereHas('roles', function ($query) {
            $query->slug = $this->request->get('role');
        });
    }

    /**
     * @return mixed
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function display()
    {
        $roles = Role::select('slug', 'name')->pluck('name', 'slug');

        return Field::tag('select')
            ->options($roles)
            ->name('role')
            ->title(trans('platform::systems/roles.title'))
            ->hr(false);
    }
}
