<?php

use Illuminate\Support\Facades\File;
use Rlimjr\LaraClean\Console\Commands\MakeDomainDto;
use Rlimjr\LaraClean\Tests\TestCase;

class MakeDomainDtoTest extends TestCase
{
    public function test_createsNewDtoClassInSpecifiedDomain()
    {
        $this->artisan('make:domain-dto', ['domain' => 'User', 'name' => 'Profile'])
            ->expectsOutput("DTO 'UserDTO' created successfully in 'User' domain.")
            ->assertExitCode(0);

        $dtoPath = base_path('app/Domain/User/DTOs/ProfileDTO.php');
        $this->assertTrue(File::exists($dtoPath));
        File::delete($dtoPath);
    }

    public function test_createsNewDtoClassWithDefaultNameIfNameNotProvided()
    {
        $this->artisan('make:domain-dto', ['domain' => 'Order'])
            ->expectsOutput("DTO 'OrderDTO' created successfully in 'Order' domain.")
            ->assertExitCode(0);

        $dtoPath = base_path('app/Domain/Order/DTOs/OrderDTO.php');
        $this->assertTrue(File::exists($dtoPath));
        File::delete($dtoPath);
    }

    public function test_throwsErrorIfDtoFileAlreadyExists()
    {
        $dtoPath = base_path('app/Domain/Product/DTOs/ProductDTO.php');
        File::ensureDirectoryExists(dirname($dtoPath));
        File::put($dtoPath, 'dummy content');

        $this->artisan('make:domain-dto', ['domain' => 'Product'])
            ->expectsOutput("DTO 'ProductDTO' already exists in the 'Product' domain.")
            ->assertExitCode(0);

        File::delete($dtoPath);
    }

    public function test_throwsExceptionIfStubFileNotFound()
    {
        $command = new MakeDomainDto();
        $stubPath = __DIR__ . '/../../stubs/dto.stub';
        File::delete($stubPath);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Stub file not found: {$stubPath}");

        $command->handle();
    }
}