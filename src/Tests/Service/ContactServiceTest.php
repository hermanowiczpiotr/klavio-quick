<?php


namespace App\Tests\Service;


use App\Entity\Contact;
use App\Service\ContactService;
use Doctrine\ORM\EntityManagerInterface;
use Klaviyo\Klaviyo;
use Klaviyo\PublicAPI;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\MockObject\MockObject as Mock;

class ContactServiceTest extends TestCase
{
    /** @var Mock | EntityManagerInterface */
    private $entityManager;

    /** @var Mock | Klaviyo */
    private $client;

    /** @var Mock | LoggerInterface */
    private $logger;

    private ContactService $contactService;

    /** @var Mock | PublicAPI */
    private $publicApi;

    protected function setUp()
    {
        $this->client = $this->createMock(Klaviyo::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->publicApi = $this->createMock(PublicAPI::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->contactService = new ContactService($this->client, $this->entityManager, $this->logger);
    }

    public function testAddContact(): void
    {
        $contact= new Contact();
        $contact->setFirstName('')
            ->setLastName('')
            ->setEmail('');

        $this->client->expects($this->once())
            ->method('__get')
            ->with($this->equalTo('publicAPI'))
            ->willReturn($this->publicApi);

        $this->publicApi->expects($this->once())
            ->method('identify')
            ->willReturn('klavId');

        $this->contactService->addContact($contact);
        $this->assertEquals('klavId', $contact->getKlaviyoId());
    }

}