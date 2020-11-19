<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\Contact;
use App\Model\TrackEvent;

interface TrackServiceInterface
{
    public function track(Contact $contact): TrackEvent;
}