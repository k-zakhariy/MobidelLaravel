<?php


namespace MobidelTests;

use Zakhariy\MobidelLaravel\MobidelCallback;

class CallbackTests extends BaseTests
{

    public function test_callback_route_works()
    {
        $config = $this->config;
        $response = $this->json('POST', $config['callback_path'], []);
        $response->assertStatus(200);
    }

    public function test_subscribe_incorrect_action()
    {
        $a = app()->make(MobidelCallback::class);
        $this->expectException(\Exception::class);
        $a->subscribeToEvents(new BaseTests(), [
            'notExistingEvent'
        ]);
    }


}