<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDomainModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain-model {domain} {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new domain model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domainName = Str::singular(ucfirst($this->argument('domain')));
        $modelName = ucfirst($this->argument('name') ?? $domainName);

        $this->createFolder($domainName, $modelName);

        $this->info("Model '{$domainName}' created successfully!");
    }

    protected function createFolder(string $domain, string $model): void
    {
        $domainPath = app_path("Domain/{$domain}/Models");

        File::ensureDirectoryExists($domainPath);

        $stub = $this->getStub($domain, $model);

        File::put($domainPath . '/' . $model . '.php', $stub);

    }

    protected function getStub($domain, $model)
    {
        // Get the content of the stub file
        $stubPath = resource_path('stubs/model.stub');
        $stub = File::get($stubPath);

        // Replace placeholders with actual values
        return str_replace(['{{domain}}', '{{model}}'], [$domain, $model], subject: $stub);
    }
}
