<?php

namespace MobidelTests;

use Orchestra\Testbench\TestCase;
use Zakhariy\MobidelLaravel\MobidelServiceProvider;

class BaseTests extends TestCase
{

    protected $config;

    public function setUp()
    {
        parent::setUp();

        $this->config = $this->app['config']->get('mobidel');
    }

    protected function getPackageProviders($app)
    {
        return [MobidelServiceProvider::class];
    }
}