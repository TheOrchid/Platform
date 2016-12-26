<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Illuminate\Http\Request;
use Orchid\Foundation\Core\Models\User;
use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Foundation\Http\Forms\Systems\Users\UserFormGroup;

class UserController extends Controller
{
    /**
     * @var
     */
    public $form = UserFormGroup::class;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->form = new $this->form();
    }

    /**
     * @return string
     */
    public function index()
    {
        return $this->form->grid();
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return $this->form
            ->route('dashboard.systems.users.store')
            ->method('POST')
            ->render();
    }

    /**
     * @param Request $request
     * @param User|null $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user = null)
    {
        $this->form->save($request, $user);

        return redirect()->back();
    }

    /**
     * @param User $user
     */
    public function edit(User $user)
    {
        return $this->form
            ->route('dashboard.systems.users.update')
            ->method('PUT')
            ->render($user);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $this->form->save($request, $user);

        return redirect()->back();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function destroy(User $user)
    {
        $this->form->remove($user);

        return redirect()->route('dashboard.systems.users');
    }
}
