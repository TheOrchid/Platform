<?php

namespace Orchid\Platform\Http\Layouts\User;

use Orchid\Platform\Fields\Field;
use Orchid\Platform\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Field::tag('input')
                ->type('text')
                ->name('user.name')
                ->max(255)
                ->require()
                ->title(trans('dashboard::systems/users.name'))
                ->placeholder(trans('dashboard::systems/users.name')),

            Field::tag('input')
                ->type('email')
                ->name('user.email')
                ->require()
                ->title(trans('dashboard::systems/users.email'))
                ->placeholder(trans('dashboard::systems/users.email')),

            Field::tag('password')
                ->name('user.password')
                ->title(trans('dashboard::systems/users.password'))
                ->placeholder('********'),
        ];
        //dd($return);
        //return $fields;
    }
}
