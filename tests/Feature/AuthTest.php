<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function testLogin()
    {
        config(['ordering.admin.password' => 'test']);

        $response = $this->from(route('login'))
                         ->post(route('login'), [
                             'password' => 'test',
                         ]);

        $response->assertRedirect(route('dashboard'))
                 ->assertCookie(config('ordering.cookie'), true);
    }

    public function testLoginFail()
    {
        config(['ordering.admin.password' => 'test']);

        $response = $this->from(route('login'))
                         ->post(route('login'));

        $response->assertRedirect(route('login'));
    }

    public function testLogout()
    {
        $response = $this->from(route('dashboard'))
                         ->post(route('logout'));

        $response->assertRedirect(route('dashboard'));
    }

    public function testDashboard()
    {
        $this->withoutMix();

        $response = $this->withMiddleware(['auth:ordering'])
                         ->withCookie(config('ordering.cookie'), 'true')
                         ->get(route('dashboard'));

        $response->assertSuccessful();
    }

    public function testDashboardRedirect()
    {
        $response = $this->withMiddleware(['auth:ordering'])
                         ->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }
}
