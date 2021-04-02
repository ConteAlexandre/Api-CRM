<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;
use function GuzzleHttp\Psr7\str;

/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 */
class Action
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=ActionType::class, inversedBy="action")
     */
    private $actionType;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="actions")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="actions")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Invoice::class, inversedBy="actions")
     */
    private $invoice;

    /**
     * @ORM\ManyToOne(targetEntity=Devis::class, inversedBy="actions")
     */
    private $devis;

    /**
     * @ORM\ManyToOne(targetEntity=Exchange::class, inversedBy="actions")
     */
    private $exchange;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->title;
    }

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return ActionType|null
     */
    public function getActionType(): ?ActionType
    {
        return $this->actionType;
    }

    /**
     * @param ActionType|null $actionType
     *
     * @return $this
     */
    public function setActionType(?ActionType $actionType): self
    {
        $this->actionType = $actionType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client|null $client
     *
     * @return $this
     */
    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Invoice|null
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @param Invoice|null $invoice
     *
     * @return $this
     */
    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @return Devis|null
     */
    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    /**
     * @param Devis|null $devis
     *
     * @return $this
     */
    public function setDevis(?Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * @return Exchange|null
     */
    public function getExchange(): ?Exchange
    {
        return $this->exchange;
    }

    /**
     * @param Exchange|null $exchange
     *
     * @return $this
     */
    public function setExchange(?Exchange $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }
}
