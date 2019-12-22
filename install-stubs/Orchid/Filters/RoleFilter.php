<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class RoleFilter extends Filter
{
    /**
     * @var array
     */
    public $parameters = [
        'role',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return __('Roles');
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder) : Builder
    {
        return $builder->whereHas( config('platform.rolesTable'), function (Builder $query) {
            $query->where('slug', $this->request->get('role'));
        });
    }

    /**
     * @return Field[]
     */
    public function display() : array
    {
        return [
            Select::make('role')
                ->fromModel(Role::class, 'slug', 'slug')
                ->empty()
                ->value($this->request->get('role'))
                ->title(__('Roles')),
        ];
    }
}
