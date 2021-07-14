<?php

namespace Drupal\drupal_address_metromanila_cities\EventSubscriber;

use Drupal\address\Event\AddressEvents;
use Drupal\address\Event\AvailableCountriesEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LimitCountriesEventSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        $events[AddressEvents::AVAILABLE_COUNTRIES][] = ['onAvailableCountries'];
        return $events;
    }

    public function onAvailableCountries(AvailableCountriesEvent $event) {
        $countries = ['PH' => 'PH'];
        $event->setAvailableCountries($countries);
    }

}