<?php

namespace Rlimjr\laraClean\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDomainMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-migration {domain} {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new domain migration.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = Str::singular(ucfirst($this->argument('domain')));
        $name = ucfirst($this->argument('name') ?? $domain);
        $domainPath = app_path("Domain/{$name}/Migrations");

        // Ensure the migration directory exists
        File::ensureDirectoryExists($domainPath);

        // Create the migration file using the provided stub
        $this->createMigrationFile($domain, $name);

        $this->info("Migration '{$name}' created successfully!");
    }

    protected function createMigrationFile($domain, $name)
    {
        // Generate a timestamp for the migration filename
        $domainPath = app_path("Domain/{$domain}/Migrations");
        $timestamp = date('Y_m_d_His');
        $migrationFileName = "{$timestamp}_{$name}.php";
        $tableName = Str::snake(Str::plural($name));

        // Migration stub content
        $stub = $this->getStub($tableName);

        // Write the stub to the migration file
        File::put($domainPath . '/' . $migrationFileName, $stub);
    }


    protected function getStub($tableName)
    {
        // Get the content of the stub file
        $stubPath = resource_path('stubs/migration.stub');
        $stub = File::get($stubPath);

        // Replace placeholders with actual values
        return str_replace('{{table_name}}', $tableName, subject: $stub);
    }

}
