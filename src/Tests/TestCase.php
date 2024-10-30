<?php

namespace Rlimjr\LaraClean\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Rlimjr\LaraClean\LaraCleanServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        // Register your package's service provider
        return [
            LaraCleanServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Set up any additional environment configuration if necessary
    }
}
