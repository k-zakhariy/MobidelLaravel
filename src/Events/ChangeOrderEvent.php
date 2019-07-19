<?php

namespace Zakhariy\MobidelLaravel\Events;

class ChangeOrderEvent extends AbstractEvent
{
    static function getEventName()
    {
        return 'changeOrder';
    }
}