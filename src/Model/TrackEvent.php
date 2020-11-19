<?php
declare(strict_types=1);

namespace App\Model;


class TrackEvent
{
    private string $event;

    private array $customerProperties;

    private array $properties;

    public function toArray()
    {
        return [
            'event' => $this->event,
            'customer_properties' => $this->customerProperties,
            'properties' => $this->properties
        ];
    }
    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): TrackEvent
    {
        $this->event = $event;
        return $this;
    }

    public function getCustomerProperties(): array
    {
        return $this->customerProperties;
    }

    public function setCustomerProperties(array $customerProperties): TrackEvent
    {
        $this->customerProperties = $customerProperties;
        return $this;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function setProperties(array $properties): TrackEvent
    {
        $this->properties = $properties;
        return $this;
    }
}