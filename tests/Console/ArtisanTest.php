<?php

declare(strict_types=1);

namespace Tests\Feature\Example;

use Orchid\Tests\TestConsoleCase;

class ArtisanTest extends TestConsoleCase
{
    /**
     * debug: php vendor/bin/phpunit  --filter= ArtisanTest tests\\Feature\\ArtisanTest --debug.
     * @var
     */
    public function test_artisan_orchid_entity_many()
    {
        $this->artisan('orchid:entity-many', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Behavior created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_entity_single()
    {
        $this->artisan('orchid:entity-single', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Behavior created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_chart()
    {
        $this->artisan('orchid:chart', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Chart created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_table()
    {
        $this->artisan('orchid:table', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Table created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_screen()
    {
        $this->artisan('orchid:screen', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Screen created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_rows()
    {
        $this->artisan('orchid:rows', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Rows created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_filter()
    {
        $this->artisan('orchid:filter', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Filter created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_metrics()
    {
        $this->artisan('orchid:metrics', ['name' => $this->generateNameFromMethod()])
            ->expectsOutput('Metric created successfully.')
            ->assertExitCode(0);
    }

    public function test_artisan_orchid_admin()
    {
        $this->artisan('orchid:admin')
            ->expectsQuestion('What is your name?', 'testConsoleCreateUser')
            ->expectsQuestion('What is your email?', 'testConsoleCreateUser@console.loc')
            ->expectsQuestion('What is the password?', 'testConsoleCreateUser')
            ->expectsOutput('User created successfully.');
    }
}
