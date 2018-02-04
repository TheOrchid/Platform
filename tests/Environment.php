<?php

namespace Orchid\Platform\Tests;

use Watson\Active\Facades\Active;
use Orchid\Platform\Facades\Alert;
use Illuminate\Support\Facades\Schema;
use Orchid\Platform\Facades\Dashboard;
use Orchid\Platform\Providers\FoundationServiceProvider;

trait Environment
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        Schema::defaultStringLength(191);

        $this->artisan('vendor:publish', [
            '--provider' => 'Orchid\Platform\Providers\FoundationServiceProvider',
        ]);

        $this->artisan('vendor:publish', [
            '--all' => true,
        ]);

        $this->artisan('orchid:link');

        //$this->loadLaravelMigrations('orchid');

        $this->artisan('migrate:fresh', [
            '--database' => 'orchid',
        ]);

        $this->artisan('storage:link');
        $this->artisan('orchid:link');

        $this->withFactories(realpath(DASHBOARD_PATH.'/database/factories'));

        $this->artisan('db:seed', [
            '--class' => 'OrchidDatabaseSeeder',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // set up database configuration
        $app['config']->set('database.connections.orchid', [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'orchid_test_database'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            /*
            'driver'   => 'pgsql',
            'host'     => '127.0.0.1',
            'port'     => '5432',
            'database' => 'platform',
            'username' => 'orchid',
            'password' => 'orchid',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
            'sslmode'  => 'prefer',
            */
        ]);
        $app['config']->set('database.default', 'orchid');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FoundationServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Dashboard' => Dashboard::class,
            'Alert'     => Alert::class,
            'Active'    => Active::class,
        ];
    }
}
