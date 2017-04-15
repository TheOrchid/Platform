<?php

namespace Orchid\Http\Composers;

use Orchid\Kernel\Dashboard;

class MenuComposer
{
    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function compose()
    {
        $this->registerMenuPost($this->dashboard);
        $this->registerMenuTools($this->dashboard);
        $this->registerMenuSystems($this->dashboard);
        $this->registerMenuMarketing($this->dashboard);
    }


    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuPost(Dashboard $dashboard)
    {
        $allPost = $dashboard->types();

        if (count($allPost) > 0) {
            $postMenu = [
                'slug'       => 'Posts',
                'icon'       => 'icon-note',
                'route'      => '#',
                'label'      => trans('dashboard::menu.Posts'),
                'childs'     => true,
                'main'       => true,
                'active'     => 'dashboard.posts.*',
                'permission' => 'dashboard.posts',
                'sort'       => 100,
            ];

            $dashboard->menu->add('Main', $postMenu);
        }
        foreach ($allPost as $page) {
            if ($page->display) {
                $postObject = [
                    'slug'       => $page->slug,
                    'icon'       => $page->icon,
                    'route'      => route('dashboard.posts.type', [$page->slug]),
                    'label'      => $page->name,
                    'childs'     => false,
                    'permission' => 'dashboard.posts.type.' . $page->slug,
                ];

                if (reset($allPost) == $page) {
                    $postObject['groupname'] = trans('dashboard::menu.Common posts');
                } elseif (end($allPost) == $page) {
                    $postObject['divider'] = true;
                }

                $dashboard->menu->add('Posts', $postObject);
            }
        }
    }

    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuTools(Dashboard $dashboard)
    {
        $dashboard->menu->add('Main', [
            'slug'       => 'Tools',
            'icon'       => 'icon-wrench',
            'route'      => '#',
            'label'      => trans('dashboard::menu.Tools'),
            'childs'     => true,
            'main'       => true,
            'active'     => 'dashboard.tools.*',
            'permission' => 'dashboard.tools',
            'sort'       => 500
        ]);

        $dashboard->menu->add('Tools', [
            'slug'       => 'section',
            'icon'       => 'icon-briefcase',
            'route'      => route('dashboard.tools.category'),
            'label'      => trans('dashboard::menu.Sections'),
            'childs'     => false,
            'divider'    => true,
            'permission' => 'dashboard.tools.category',
            'sort'       => 2
        ]);

        $dashboard->menu->add('Tools', [
            'slug'       => 'menu',
            'icon'       => 'icon-menu',
            'route'      => route('dashboard.tools.menu.index'),
            'label'      => trans('dashboard::menu.Menu'),
            'groupname'  => trans('dashboard::menu.Posts Managements'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.tools.menu',
            'sort'       => 1
        ]);

        $dashboard->menu->add('Tools', [
            'slug'       => 'media',
            'icon'       => 'icon-folder-alt',
            'route'      => route('dashboard.tools.media.index'),
            'label'      => 'Media',
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.tools.media',
            'sort'       => 3
        ]);
    }

    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuSystems(Dashboard $dashboard)
    {
        $dashboard->menu->add('Main', [
            'slug'       => 'Systems',
            'icon'       => 'icon-organization',
            'route'      => '#',
            'label'      => trans('dashboard::menu.Systems'),
            'childs'     => true,
            'main'       => true,
            'active'     => 'dashboard.systems.*',
            'permission' => 'dashboard.systems',
            'sort'       => 1000
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'settings',
            'icon'       => 'fa fa-cog',
            'route'      => route('dashboard.systems.settings'),
            'label'      => trans('dashboard::menu.Constants'),
            'groupname'  => trans('dashboard::menu.General settings'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.settings',
            'sort'       => 1
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'backup',
            'icon'       => 'fa fa-history',
            'route'      => route('dashboard.systems.backup'),
            'label'      => trans('dashboard::menu.Backups'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.backup',
            'sort'       => 2
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'logs',
            'icon'       => 'fa fa-bug',
            'route'      => route('dashboard.systems.logs.index'),
            'label'      => trans('dashboard::menu.Logs'),
            'groupname'  => trans('dashboard::menu.Errors'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.logs',
            'sort'       => 500
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'defender',
            'icon'       => 'fa fa-shield',
            'route'      => route('dashboard.systems.defender.index'),
            'label'      => trans('dashboard::menu.Defender'),
            'permission' => 'dashboard.systems.defender',
            'sort'       => 501
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'monitor',
            'icon'       => 'fa fa-television',
            'route'      => route('dashboard.systems.monitor'),
            'label'      => trans('dashboard::menu.Monitor'),
            'permission' => 'dashboard.systems.monitor',
            'sort'       => 502
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'schema',
            'icon'       => 'fa fa-database',
            'route'      => route('dashboard.systems.schema.index'),
            'label'      => trans('dashboard::menu.Schema'),
            'childs'     => false,
            'divider'    => true,
            'permission' => 'dashboard.systems.schema',
            'sort'       => 3
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'users',
            'icon'       => 'icon-user',
            'route'      => route('dashboard.systems.users'),
            'label'      => trans('dashboard::menu.Users'),
            'groupname'  => trans('dashboard::menu.Users'),
            'childs'     => false,
            'divider'    => false,
            'permission' => 'dashboard.systems.users',
            'sort'       => 503
        ]);

        $dashboard->menu->add('Systems', [
            'slug'       => 'roles',
            'icon'       => 'fa fa-lock',
            'route'      => route('dashboard.systems.roles'),
            'label'      => trans('dashboard::menu.Roles'),
            'childs'     => false,
            'divider'    => true,
            'permission' => 'dashboard.systems.roles',
            'sort'       => 601
        ]);
    }

    /**
     * @param Dashboard $dashboard
     */
    protected function registerMenuMarketing(Dashboard $dashboard)
    {
        $dashboard->menu->add('Main', [
            'slug'       => 'Marketing',
            'icon'       => 'icon-chart',
            'route'      => '#',
            'label'      => trans('dashboard::menu.Marketing'),
            'childs'     => true,
            'main'       => true,
            'active'     => 'dashboard.marketing.*',
            'permission' => 'dashboard.marketing',
            'sort'       => 1500
        ]);

        $dashboard->menu->add('Marketing', [
            'slug'       => 'comment',
            'icon'       => 'fa fa-comments-o',
            'route'      => route('dashboard.marketing.comment'),
            'label'      => trans('dashboard::menu.Comments'),
            'groupname'  => trans('dashboard::menu.Marketing'),
            'permission' => 'dashboard.marketing.comment',
            'sort'       => 1
        ]);

        $dashboard->menu->add('Marketing', [
            'slug'       => 'advertising',
            'icon'       => 'icon-target',
            'route'      => route('dashboard.marketing.advertising.index'),
            'label'      => trans('dashboard::menu.Advertising'),
            'permission' => 'dashboard.marketing.advertising',
            'sort'       => 5
        ]);

        $dashboard->menu->add('Marketing', [
            'slug'       => 'utm',
            'icon'       => 'fa fa-link',
            'route'      => route('dashboard.marketing.utm.index'),
            'label'      => trans('dashboard::menu.UTM'),
            'permission' => 'dashboard.marketing.utm',
            'sort'       => 10
        ]);
    }
}
