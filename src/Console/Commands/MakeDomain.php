<?php

namespace Rlimjr\laraClean\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeDomain extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:domain {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new domain for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domainName = ucfirst($this->argument('name'));

        $folders = [
            'Repositories',
            'Services',
        ];

        // run php artisan make:class
        foreach ($folders as $folder) {
            $this->call('make:class', [
                'name' => $this->createFolder($folder, $domainName),
            ]);
        }

        $this->call('make:domain-model', [
            'domain' => $domainName,
        ]);

        // Create DTO
        $this->call('make:domain-dto', [
            'domain' => $domainName
        ]);

        // Create Migrations
        $this->call('make:domain-migration', [
            'domain' => $domainName,
        ]);

        $this->info("Domain structure for '{$domainName}' created successfully!");
    }

    private function createFolder(string $folder, string $domainName): string
    {
        $fileName = '';
        switch ($folder) {
            case 'Repositories':
                $fileName = $domainName . 'Repository';
                break;
            case 'Services':
                $fileName = $domainName . 'Service';
                break;
            case 'DTOs':
                $fileName = $domainName . 'DTO';
                break;
        }

        return sprintf('Domain\\%s\\%s\\%s', Str::singular($domainName), Str::plural($folder), $fileName);
    }
}
