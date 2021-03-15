<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    use TimestampableEntity,
        BlameableEntity,
        EnabledEntityTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberPhone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isProspect;

    /**
     * @ORM\ManyToOne(targetEntity=ClientActivity::class, inversedBy="clients")
     */
    private $clientActivity;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * @param \DateTimeInterface $birthday
     *
     * @return $this
     */
    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumberPhone(): ?string
    {
        return $this->numberPhone;
    }

    /**
     * @param string $numberPhone
     *
     * @return $this
     */
    public function setNumberPhone(string $numberPhone): self
    {
        $this->numberPhone = $numberPhone;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsProspect(): ?bool
    {
        return $this->isProspect;
    }

    /**
     * @param bool $isProspect
     *
     * @return $this
     */
    public function setIsProspect(bool $isProspect): self
    {
        $this->isProspect = $isProspect;

        return $this;
    }

    /**
     * @return ClientActivity|null
     */
    public function getClientActivity(): ?ClientActivity
    {
        return $this->clientActivity;
    }

    /**
     * @param ClientActivity|null $clientActivity
     *
     * @return $this
     */
    public function setClientActivity(?ClientActivity $clientActivity): self
    {
        $this->clientActivity = $clientActivity;

        return $this;
    }
}
