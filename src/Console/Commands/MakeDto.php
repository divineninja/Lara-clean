<?php

namespace Rlimjr\laraClean\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeDto extends Command
{
    protected $signature = 'make:domain-dto {domain} {name?}';
    protected $description = 'Create a new DTO class in the specified domain';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = Str::singular(ucfirst($this->argument('domain')));
        $name = ucfirst($this->argument('name') ?? $domain);
        $dtoPath = base_path("app/Domain/{$domain}/DTOs/{$name}DTO.php");

        // Create the DTO directory if it doesn't exist
        if (!File::exists(dirname($dtoPath))) {
            File::makeDirectory(dirname($dtoPath), 0755, true);
        }

        // Check if the DTO file already exists
        if (File::exists($dtoPath)) {
            $this->error("DTO '{$name}DTO' already exists in the '{$domain}' domain.");
            return;
        }

        // DTO stub content
        $stub = $this->getStub($domain, $name);

        // Write the stub to the new file
        File::put($dtoPath, $stub);
        $this->info("DTO '{$domain}DTO' created successfully in '{$domain}' domain.");
    }

    protected function getStub($domain, $model)
    {
        // Get the content of the stub file
        $stubPath = resource_path('stubs/dto.stub');
        $stub = File::get($stubPath);

        // Replace placeholders with actual values
        return str_replace(['{{domain}}', '{{model}}'], [$domain, $model], subject: $stub);
    }

}
