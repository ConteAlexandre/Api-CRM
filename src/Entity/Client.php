<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use libphonenumber\PhoneNumber;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="3",
     *     minMessage="The firstName must do {{ limit }} characters minimum !",
     *     max="30",
     *     maxMessage="The firstName must do {{ limit }} characters maximum !"
     * )
     *
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="3",
     *     minMessage="The lastName must do {{ limit }} characters minimum !",
     *     max="30",
     *     maxMessage="The lastName must do {{ limit }} characters maximum !"
     * )
     *
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @Gedmo\Slug(fields={"lastName", "firstName"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(
     *     min="15",
     *     minMessage="The email must do {{ limit }} characters minimum !",
     *     max="100",
     *     maxMessage="The email must do {{ limit }} characters maximum !"
     * )
     *
     * @ORM\Column(type="string", length=150, name="email")
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\DateTime()
     *
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @var PhoneNumber
     *
     * @ORM\Column(type="phone_number", length=255)
     */
    private $numberPhone;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Groups({"client"})
     */
    private $isProspect;

    /**
     * @ORM\ManyToOne(targetEntity=ClientActivity::class, inversedBy="clients")
     */
    private $clientActivity;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="client")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Action::class, mappedBy="client")
     */
    private $actions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isArchived;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="client")
     */
    private $invoices;

    /**
     * @ORM\OneToMany(targetEntity=Exchange::class, mappedBy="client")
     */
    private $exchanges;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->actions = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->exchanges = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->firstName;
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
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
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
     * @return PhoneNumber|null
     */
    public function getNumberPhone(): ?PhoneNumber
    {
        return $this->numberPhone;
    }

    /**
     * @param PhoneNumber $numberPhone
     *
     * @return $this
     */
    public function setNumberPhone(PhoneNumber $numberPhone): self
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
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    /**
     * @param Action $action
     *
     * @return $this
     */
    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setClient($this);
        }

        return $this;
    }

    /**
     * @param Action $action
     *
     * @return $this
     */
    public function removeAction(Action $action): self
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getClient() === $this) {
                $action->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    /**
     * @param bool $isArchived
     *
     * @return $this
     */
    public function setIsArchived(bool $isArchived): self
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    /**
     * @param Invoice $invoice
     *
     * @return $this
     */
    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setClient($this);
        }

        return $this;
    }

    /**
     * @param Invoice $invoice
     *
     * @return $this
     */
    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getClient() === $this) {
                $invoice->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Exchange[]
     */
    public function getExchanges(): Collection
    {
        return $this->exchanges;
    }

    public function addExchange(Exchange $exchange): self
    {
        if (!$this->exchanges->contains($exchange)) {
            $this->exchanges[] = $exchange;
            $exchange->setClient($this);
        }

        return $this;
    }

    public function removeExchange(Exchange $exchange): self
    {
        if ($this->exchanges->removeElement($exchange)) {
            // set the owning side to null (unless already changed)
            if ($exchange->getClient() === $this) {
                $exchange->setClient(null);
            }
        }

        return $this;
    }
}
