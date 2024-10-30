<?php
namespace Rlimjr\LaraClean\Tests\Unit\Console;

use Rlimjr\LaraClean\Tests\TestCase;

class MakeDomainModelTest extends TestCase
{
    public function test_createsNewDomainModelWithSpecifiedName()
    {
        $this->artisan('make:domain-model', ['domain' => 'User', 'name' => 'Profile'])
            ->expectsOutput("Model 'User' created successfully!")
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Domain/User/Models/Profile.php'));
    }

    public function test_createsNewDomainModelWithDefaultName()
    {
        $this->artisan('make:domain-model', ['domain' => 'User'])
            ->expectsOutput("Model 'User' created successfully!")
            ->assertExitCode(0);

        $this->assertFileExists(app_path('Domain/User/Models/User.php'));
    }
}