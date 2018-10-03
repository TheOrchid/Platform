<?php

declare(strict_types=1);

namespace Orchid\Platform\Models;

use Orchid\Screen\TD;
use Orchid\Access\UserAccess;
use Orchid\Access\UserInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Orchid\Support\Facades\Dashboard;
use Orchid\Platform\Traits\FilterTrait;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravolt\Avatar\Facade as AvatarGenerator;
use Orchid\Platform\Traits\MultiLanguageTrait;
use Orchid\Platform\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements UserInterface
{
    use Notifiable, UserAccess, MultiLanguageTrait, FilterTrait, LogsActivity;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login',
        'avatar',
        'permissions',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'locale' => 'en',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * @var
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * @var
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
    ];

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Display name.
     *
     * @return mixed
     */
    public function getNameTitle()
    {
        return $this->name;
    }

    /**
     * Display sub.
     *
     * @return string
     */
    public function getSubTitle()
    {
        return 'Administrator';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getFieldsTable(): Collection
    {
        return collect([
            'id'         => TD::set('id', 'ID')
                ->align('center')
                ->width('100px')
                ->sort()
                ->link('platform.systems.users.edit', 'id'),
            'name'       => TD::set('name', trans('platform::systems/users.name'))
                ->sort()
                ->link('platform.systems.users.edit', 'id', 'name'),
            'email'      => TD::set('email', trans('platform::systems/users.email'))
                ->loadModalAsync('oneAsyncModal', 'saveUser', 'id', 'email')
                ->sort(),
            'updated_at' => TD::set('updated_at', trans('platform::common.Last edit'))
                ->sort(),
        ]);
    }

    /**
     * @param $name
     * @param $email
     * @param $password
     *
     * @return mixed
     */
    public static function createAdmin($name, $email, $password)
    {
        if (static::where('email', $email)->exists()) {
            echo 'User exist', PHP_EOL;
            die();
        }

        $permissions = collect();

        Dashboard::getPermission()
            ->collapse()
            ->each(function ($item) use ($permissions) {
                $permissions->put($item['slug'], true);
            });

        $user = static::create([
            'name'        => $name,
            'email'       => $email,
            'password'    => bcrypt($password),
            'permissions' => $permissions,
            'locale'      => App::getLocale(),
        ]);

        $user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
            'title'   => "Welcome {$name}",
            'message' => 'You can find the latest news of the project on the website',
            'action'  => 'https://orchid.software/',
            'type'    => 'info',
        ]));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getAvatar()
    {
        $name = title_case(str_slug($this->getNameTitle(), ' '));

        return AvatarGenerator::create($name)
            //->setBackground('#fff')
            //->setForeground('#363f44')
            ->setBorder(0, '#fff')
            ->toBase64();
    }

    /**
     * @return mixed
     */
    public function getStatusPermission()
    {
        return Dashboard::getPermission()
            ->sort()
            ->transform(function ($group) {
                $group = collect($group)->sortBy('description')->toArray();

                foreach ($group as $key => $value) {
                    $group[$key]['active'] = array_key_exists($value['slug'], $this->permissions ?? []);
                }

                return $group;
            });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getStatusRoles()
    {
        return collect($this->roles)
            ->transform(function ($role) {
                $role->active = true;

                return $role;
            })->union(Role::all());
    }
}
