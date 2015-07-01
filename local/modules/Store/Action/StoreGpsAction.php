<?php
/**
 * Created by PhpStorm.
 * User: thelia
 * Date: 01/07/2015
 * Time: 12:49
 */

namespace Store\Action;


use Store\Event\StoreEvent;
use Store\Event\StoreEvents;
use Store\Model\StoreQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StoreGpsAction implements EventSubscriberInterface {

    public function saveGps(StoreEvent $event)
    {
        $store = StoreQuery::create()->findPk($event->getId());

        if (null !== $store) {
            $store
                ->setLat($event->getLat())
                ->setLng($event->getLng())
                ->save()
            ;

            $event->setStore($store);
        }

    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            StoreEvents::STORE_GPS_UPDATE => 'saveGps'
        ];
    }
}