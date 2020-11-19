<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Contact;
use App\Factory\TrackEventFactory;
use App\Model\TrackEvent;
use Klaviyo\Exception\KlaviyoException;
use Klaviyo\Klaviyo;
use Klaviyo\Model\EventModel;
use Psr\Log\LoggerInterface;

class TrackService implements TrackServiceInterface
{
    private const EVENT_NAME = 'event name';

    private const EVENT_PROPERTIES = [
        'tracked' => true
    ];

    private Klaviyo $client;

    private LoggerInterface $logger;

    private TrackEventFactory $trackEventFactory;

    public function __construct(TrackEventFactory $trackEventFactory, Klaviyo $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->trackEventFactory = $trackEventFactory;
    }

    public function track(Contact $contact): TrackEvent
    {
        try {
            $trackEvent = $this->trackEventFactory->create(self::EVENT_NAME, ['$email' => $contact->getEmail()], self::EVENT_PROPERTIES);
            $event = new EventModel($trackEvent->toArray());
            $this->client->publicAPI->track($event);
            return $trackEvent;
        } catch (KlaviyoException $e) {
            $this->logger->error(sprintf('[Klaviyo] Error: %s', $e->getMessage()));
            throw $e;
        }
    }
}