<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntityTrait;
use App\Repository\ActionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=ActionTypeRepository::class)
 */
class ActionType
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Action::class, mappedBy="actionType")
     */
    private $action;

    /**
     * ActionType constructor.
     */
    public function __construct()
    {
        $this->action = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getAction(): Collection
    {
        return $this->action;
    }

    /**
     * @param Action $action
     *
     * @return $this
     */
    public function addAction(Action $action): self
    {
        if (!$this->action->contains($action)) {
            $this->action[] = $action;
            $action->setActionType($this);
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
        if ($this->action->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getActionType() === $this) {
                $action->setActionType(null);
            }
        }

        return $this;
    }
}
