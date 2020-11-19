<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ContactRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $klaviyoId;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected DateTime $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected DateTime $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Contact
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Contact
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    public function getKlaviyoId(): ?string
    {
        return $this->klaviyoId;
    }

    public function setKlaviyoId(string $klaviyoId): Contact
    {
        $this->klaviyoId = $klaviyoId;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Contact
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): Contact
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new DateTime('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }
}
