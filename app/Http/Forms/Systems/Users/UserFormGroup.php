<?php

namespace Orchid\Http\Forms\Systems\Users;

use Illuminate\Contracts\View\View;
use Orchid\Core\Models\User;
use Orchid\Events\Systems\UserEvent;
use Orchid\Forms\FormGroup;

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
    public function attributes(): array
    {
        return [
            'name'        => 'Пользователи',
            'description' => 'Описание раздела пользователи',
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View|\Illuminate\View\View
     */
    public function main(): View
    {
        $user = new User();
        $users = $user->select('id', 'name', 'email', 'created_at', 'updated_at')->paginate();

        return view(
            'dashboard::container.systems.users.grid',
            [
                'users' => $users,
            ]
        );
    }
}
