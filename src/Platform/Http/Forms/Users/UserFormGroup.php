<?php

namespace Orchid\Platform\Http\Forms\Systems\Users;

use Illuminate\Contracts\View\View;
use Orchid\Platform\Forms\FormGroup;
use Orchid\Platform\Core\Models\User;
use Orchid\Platform\Events\Systems\UserEvent;

class UserFormGroup extends FormGroup
{
    /**
     * @var
     */
    public $event = UserEvent::class;

    /**
     * Description Attributes for group.
     *
     * @return array
     */
    public function attributes() : array
    {
        return [
            'name'        => trans('dashboard::systems/users.title'),
            'description' => trans('dashboard::systems/users.description'),
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main() : View
    {
        $users = config('platform.common.user');
        $users = (new $users);

        return view('dashboard::container.systems.users.grid', [
            'users' => User::paginate(),
            'grid'  => $users->grid(),
        ]);
    }
}
