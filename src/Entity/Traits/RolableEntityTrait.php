<?php
/*
 * This file is part of the YesWeHack JobBoards
 *
 * (c) Guillaume Vassault-Houlière <g.vassaulthouliere@yeswehack.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RolableEntityTrait
 *
 * @author CONTE Alexandre <a.contee@yeswehack.com>
 */
trait RolableEntityTrait
{
    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json")
     */
    protected $roles;

    /**
     * Get Default role
     *
     * @return string
     */
    abstract public static function getDefaultRole();

    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = [];

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * @param string $role
     *
     * @return $this
     */
    public function addRole(string $role): self
    {
        $role = strtoupper($role);
        if (static::getDefaultRole() === $role) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param string $role
     *
     * @return $this
     */
    public function removeRole(string $role): self
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        if (null !== ($defaultRole = static::getDefaultRole())) {
            $roles[] = $defaultRole;
        }

        return array_unique($roles);
    }

    /**
     * Does user has role $role?
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

}