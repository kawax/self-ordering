<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login()
    {
        config(['ordering.admin.password' => 'test']);

        $response = $this->from(route('login'))
            ->post(route('login'), [
                'password' => 'test',
            ]);

        $response->assertRedirect(route('dashboard'))
            ->assertCookie(config('ordering.cookie'), true);
    }

    public function test_login_fail()
    {
        config(['ordering.admin.password' => 'test']);

        $response = $this->from(route('login'))
            ->post(route('login'));

        $response->assertRedirect(route('login'));
    }

    public function test_logout()
    {
        $response = $this->from(route('dashboard'))
            ->post(route('logout'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_dashboard()
    {
        $this->withoutVite();

        $response = $this->withMiddleware(['auth:ordering'])
            ->withCookie(config('ordering.cookie'), 'true')
            ->get(route('dashboard'));

        $response->assertSuccessful();
    }

    public function test_dashboard_redirect()
    {
        $response = $this->withMiddleware(['auth:ordering'])
            ->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }
}
