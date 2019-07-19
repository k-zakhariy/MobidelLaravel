## Laravel package for http://mobidel.ru/

## Initialization
Simply register events you want to listen by each observer
````php
<?php
namespace App\Providers;

class AppServiceProvider extends ServiceProvider{
    public function boot(){
        MobidelCallback::subscribeToEvents(app()->make(MobidelCallbackListener::class), [
            ChangeOrderEvent::getEventName()
        ]);
    }
}
````

Then implement method inside observer , like onChangeOrder
- Once callback runs - you will receive the data

```php
<?php

namespace App\Listeners;

use App\Models\Order;
use Zakhariy\MobidelLaravel\Events\ChangeOrderEvent;
use Zakhariy\MobidelLaravel\MobidelApi;

class MobidelCallbackListener
{

    private $order = null;
    private $mobidelOrder = null;
    private $mobidelApi;

    /**
     * MobidelCallbackListener constructor.
     * @param $mobidelApi
     */
    public function __construct(MobidelApi $mobidelApi)
    {
        $this->mobidelApi = $mobidelApi;
    }

    public function onChangeOrder(ChangeOrderEvent $event)
    {
        $callbackResponse = $event->getCallbackResponse();

        if (!isset(Order::CRM_STATUSES[$callbackResponse->getStatus()])) {
            return;
        }
        // Do anything you want with data
        $orderData = $this->mobidelApi->getOrder($callbackResponse->getOrderID());

    }
}
```