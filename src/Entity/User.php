<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use libphonenumber\PhoneNumber;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirements;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
     *     min="5",
     *     minMessage="The username must do {{ limit }} characters minimum !",
     *     max="50",
     *     maxMessage="The username must do {{ limit }} characters maximum !",
     * )
     *
     * @ORM\Column(type="string", length=150)
     */
    private $username;

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
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(
     *     min="15",
     *     minMessage="The email must do {{ limit }} characters minimum !",
     *     max="100",
     *     maxMessage="The email must do {{ limit }} characters maximum !"
     * )
     *
     * @ORM\Column(type="string", length=150)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @PasswordRequirements(
     *     minLength=8,
     *     requireLetters=true,
     *     requireNumbers=true,
     *     requireCaseDiff=true,
     *     requireSpecialCharacter=true,
     * )
     */
    private $plainPassword;

    /**
     * @var PhoneNumber
     *
     * @ORM\Column(type="phone_number", length=255, name="phone_number")
     */
    private $phoneNumber;


    /**
     * @Gedmo\Slug(fields={"lastName", "firstName"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="user")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="user")
     */
    private $invoice;

    /**
     * @ORM\OneToMany(targetEntity=Devis::class, mappedBy="user")
     */
    private $devis;

    /**
     * @ORM\OneToMany(targetEntity=Exchange::class, mappedBy="user")
     */
    private $Exchange;

    public function __construct()
    {
        $this->client = new ArrayCollection();
        $this->invoice = new ArrayCollection();
        $this->devis = new ArrayCollection();
        $this->Exchange = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->username;
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
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getPhoneNumber(): ?PhoneNumber
    {
        return $this->phoneNumber;
    }

    /**
     * @param PhoneNumber $phoneNumber
     *
     * @return $this
     */
    public function setPhoneNumber(PhoneNumber $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return array|string[]|null
     */
    public function getRoles(): ?array
    {
        if (empty($this->roles)){
            return ['ROLE_USER'];
        }
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     *
     * @return $this
     */
    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    /**
     * @param string|null $resetToken
     *
     * @return $this
     */
    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * Erase credential
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Client[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setUser($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getUser() === $this) {
                $client->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoice(): Collection
    {
        return $this->invoice;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoice->contains($invoice)) {
            $this->invoice[] = $invoice;
            $invoice->setUser($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoice->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getUser() === $this) {
                $invoice->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): self
    {
        if (!$this->devis->contains($devi)) {
            $this->devis[] = $devi;
            $devi->setUser($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): self
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getUser() === $this) {
                $devi->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Exchange[]
     */
    public function getExchange(): Collection
    {
        return $this->Exchange;
    }

    public function addExchange(Exchange $exchange): self
    {
        if (!$this->Exchange->contains($exchange)) {
            $this->Exchange[] = $exchange;
            $exchange->setUser($this);
        }

        return $this;
    }

    public function removeExchange(Exchange $exchange): self
    {
        if ($this->Exchange->removeElement($exchange)) {
            // set the owning side to null (unless already changed)
            if ($exchange->getUser() === $this) {
                $exchange->setUser(null);
            }
        }

        return $this;
    }
}
