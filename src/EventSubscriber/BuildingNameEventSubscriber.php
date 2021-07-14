<?php

namespace Drupal\drupal_address_metromanila_cities\EventSubscriber;

use Drupal\address\Event\AddressEvents;
use Drupal\address\Event\AddressFormatEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BuildingNameEventSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        $events[AddressEvents::ADDRESS_FORMAT][] = ['onAddressFormat'];
        return $events;
    }

    public function onAddressFormat(AddressFormatEvent $event) {
        $definition = $event->getDefinition();

        // Place %additionalName after %organization in the format.
        $format = $definition['format'];
        $format = str_replace('%additionalName', '', $format);
        $format = str_replace('%organization', "%organization\n%additionalName", $format);
        $definition['format'] = $format;

        $event->setDefinition($definition);
    }
}