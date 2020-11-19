<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Klaviyo\Exception\KlaviyoException;
use Klaviyo\Klaviyo;
use Klaviyo\Model\ProfileModel;
use Psr\Log\LoggerInterface;

class ContactService implements ContactServiceInterface
{
    private Klaviyo $client;

    private LoggerInterface $logger;

    private EntityManagerInterface $entityManager;

    public function __construct(Klaviyo $client, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function addContact(Contact $contact): Contact
    {
        try {
            $profile = new ProfileModel([
                '$email' => $contact->getEmail(),
                '$first_name' => $contact->getFirstName(),
                '$last_name' => $contact->getLastName(),
            ]);

            $klaviyoId = $this->client->publicAPI->identify($profile);
            $contact->setKlaviyoId($klaviyoId);
            $this->entityManager->persist($contact);
            $this->entityManager->flush();
            return $contact;
        } catch (KlaviyoException $e) {
            $this->logger->error(sprintf('[Klaviyo] Error: %s', $e->getMessage()));
            throw $e;
        }
    }
}