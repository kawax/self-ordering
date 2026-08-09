<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Application;
use Livewire\LivewireServiceProvider;
use Revolution\Ordering\Providers\OrderingServiceProvider;
use Revolution\PayPay\PayPayServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Load package service provider.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        $providers = [
            LivewireServiceProvider::class,
            OrderingServiceProvider::class,
        ];

        if (class_exists(PayPayServiceProvider::class)) {
            $providers[] = PayPayServiceProvider::class;
        }

        return $providers;
    }

    /**
     * Load package alias.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
