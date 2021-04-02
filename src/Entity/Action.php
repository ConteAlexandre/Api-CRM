<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="actions")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Invoice::class, inversedBy="actions")
     */
    private $invoice;

    /**
     * @ORM\ManyToOne(targetEntity=Exchange::class, inversedBy="actions")
     */
    private $exchange;

    /**
     * @ORM\ManyToOne(targetEntity=Devis::class, inversedBy="actions")
     */
    private $devis;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
}
