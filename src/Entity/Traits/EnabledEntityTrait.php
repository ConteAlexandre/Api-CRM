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
 * Class EnabledEntityTrait
 */
trait EnabledEntityTrait
{
    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return true === $this->enabled;
    }
}