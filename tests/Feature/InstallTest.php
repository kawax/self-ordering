<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class InstallTest extends TestCase
{
    public function test_install()
    {
        $this->artisan('ordering:install')
             ->assertSuccessful()
             ->expectsOutput('Ordering scaffolding installed successfully.');

        $this->assertFileExists(base_path('vercel.json'));
        $this->assertFileExists(base_path('.vercelignore'));
        $this->assertFileExists(base_path('api/index.php'));
    }
}
