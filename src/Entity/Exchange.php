<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\ExchangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ExchangeRepository::class)
 */
class Exchange
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
     *     minMessage="The title must do {{ limit }} characters minimum !",
     *     max="30",
     *     maxMessage="The title must do {{ limit }} characters maximum !"
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="array")
     */
    private $type = [];

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="20",
     *     minMessage="The title must do {{ limit }} characters minimum !",
     * )
     *
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity=Action::class, mappedBy="exchange")
     */
    private $actions;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="exchanges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * Exchange constructor.
     */
    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

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
     * @return array|null
     */
    public function getType(): ?array
    {
        return $this->type;
    }

    /**
     * @param array $type
     *
     * @return $this
     */
    public function setType(array $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

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
            $action->setExchange($this);
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
            if ($action->getExchange() === $this) {
                $action->setExchange(null);
            }
        }

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
