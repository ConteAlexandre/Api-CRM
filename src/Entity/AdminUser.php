<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirements;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdminUserRepository::class)
 */
class AdminUser implements UserInterface
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
     * @Assert\Email()
     * @Assert\Length(
     *     min="15",
     *     minMessage="The email must do {{ limit }} characters minimum !",
     *     max="100",
     *     maxMessage="The email must do {{ limit }} characters maximum !"
     * )
     *
     * @ORM\Column(type="string", length=100)
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
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetToken;

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
    public function getEmail(): ?string
    {
        return $this->email;
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
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return AdminUser
     */
    public function setPlainPassword(string $plainPassword): AdminUser
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return array|string[]|null
     */
    public function getRoles(): ?array
    {
        if (empty($this->roles)){
            return ['ROLE_ADMIN'];
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
     * Erase credentials
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
