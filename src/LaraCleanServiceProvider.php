<?php

namespace Rlimjr\LaraClean;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class LaraCleanServiceProvider extends ServiceProvider
{

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        // ServerProvider::class => DigitalOceanServerProvider::class,
    ];

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        // DowntimeNotifier::class => PingdomDowntimeNotifier::class,
    ];


    /**
     * Register services.
     */
    public function register(): void
    {
        $this->loadDomainMigrations();

        $this->commands([
            \Rlimjr\LaraClean\Console\Commands\MakeDomain::class,
            \Rlimjr\LaraClean\Console\Commands\MakeDomainMigration::class,
            \Rlimjr\LaraClean\Console\Commands\MakeDomainModel::class,
            \Rlimjr\LaraClean\Console\Commands\MakeDto::class
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    protected function loadDomainMigrations()
    {
        $domainPath = app_path('Domain');

        if (File::isDirectory($domainPath)) {
            $domains = File::directories($domainPath);

            foreach ($domains as $domain) {
                $migrationPath = $domain . '/Migrations';

                // Check if the migrations directory exists
                if (File::isDirectory($migrationPath)) {
                    $this->loadMigrationsFrom($migrationPath);
                }
            }
        }
    }
}
