<?php

namespace Orchid\Platform\Tests;

use Orchid\Platform\Kernel\Dashboard;

class MenuTest extends TestCase
{
    /**
     * Verify permissions.
     */
    public function test_is_menu()
    {
        $menu = (new Dashboard())->menu;

        $menu->add('Main', [
            'slug'   => 'Test',
            'icon'   => 'icon-layers',
            'route'  => '#',
            'label'  => 'Main Test',
            'childs' => true,
            'main'   => true,
            'sort'   => 1000,
        ]);

        $this->assertEquals(!is_null($menu->render('Main')), true);
        $this->assertEquals($menu->container->count(), 1);

        $menu->add('Test', [
            'slug'    => 'users',
            'icon'    => 'icon-user',
            'route'   => '#',
            'label'   => 'Sup Test',
            'childs'  => false,
            'divider' => false,
            'sort'    => 503,
        ]);

        $this->assertEquals(!is_null($menu->render('Test')), true);
    }
}
