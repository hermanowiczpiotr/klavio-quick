<?php
declare(strict_types=1);

namespace App\Factory;

use App\Model\TrackEvent;

class TrackEventFactory
{
    public function create(string $event, array $customerProperties, array $properties): TrackEvent
    {
        $trackEvent = new TrackEvent();
        $trackEvent
            ->setEvent($event)
            ->setCustomerProperties($customerProperties)
            ->setProperties($properties);

        return $trackEvent;
    }
}