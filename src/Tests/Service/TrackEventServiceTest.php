<?php


namespace App\Tests\Service;

use App\Entity\Contact;
use App\Factory\TrackEventFactory;
use App\Model\TrackEvent;
use App\Service\TrackService;
use App\Service\TrackServiceInterface;
use Klaviyo\Klaviyo;
use Klaviyo\PublicAPI;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject as Mock;
use Psr\Log\LoggerInterface;

class TrackEventServiceTest extends TestCase
{
    private TrackEventFactory $trackFactory;

    /** @var Mock | Klaviyo */
    private $client;

    /** @var Mock | LoggerInterface */
    private $logger;

    private TrackService $trackService;

    /** @var Mock | Contact */
    private $contact;

    /** @var Mock | PublicAPI */
    private $publicApi;

    protected function setUp()
    {
        $this->client = $this->createMock(Klaviyo::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->contact = $this->createMock(Contact::class);
        $this->publicApi = $this->createMock(PublicAPI::class);

        $this->trackFactory = new TrackEventFactory();
        $this->trackService = new TrackService($this->trackFactory, $this->client, $this->logger);
    }

    public function testTrack(): void
    {
        $this->client->expects($this->once())
            ->method('__get')
            ->with($this->equalTo('publicAPI'))
            ->willReturn($this->publicApi);

        $trackEvent = $this->trackService->track($this->contact);
        $this->assertEquals('event name', $trackEvent->getEvent());
    }

}