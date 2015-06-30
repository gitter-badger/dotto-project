<?php
/**
 * Created by PhpStorm.
 * User: thelia
 * Date: 30/06/2015
 * Time: 12:28
 */

namespace WareHouse\Hook;


use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class WareHouseHook extends BaseHook
{
    public function onMainInTopMenuItems(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                "top-menu.html"
            )
        );
    }
}