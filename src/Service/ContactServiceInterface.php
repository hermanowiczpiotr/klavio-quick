<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\Contact;

interface ContactServiceInterface
{
    public function addContact(Contact $contact): Contact;
}