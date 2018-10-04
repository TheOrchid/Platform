<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Composers;

use Orchid\Platform\Dashboard;
use Orchid\Press\Entities\Single;

class PressMenuComposer
{
    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Registering the main menu items.
     */
    public function compose()
    {
        $this
            ->registerMenuPost($this->dashboard);
    }

    /**
     * @param Dashboard $kernel
     *
     * @return $this
     */
    protected function registerMenuPost(Dashboard $kernel): self
    {
        $allPost = $this->dashboard->getEntities()
            ->where('display', true)
            ->all();

        $active = collect();

        foreach ($allPost as $key => $page) {
            $route = is_a($page, Single::class) ? 'platform.pages.show' : 'platform.posts.type';

            $active
                ->push($route)
                ->push($route.'*');

            $kernel->menu->add('Main', [
                'slug'       => $page->slug,
                'icon'       => $page->icon,
                'route'      => route($route, [$page->slug]),
                'label'      => $page->name,
                'permission' => 'platform.posts.type.'.$page->slug,
                'sort'       => $key,
                'groupname'  => $page->groupname,
                'divider'    => $page->divider,
                'show'       => $page->display,
            ]);
        }

        return $this;
    }
}
