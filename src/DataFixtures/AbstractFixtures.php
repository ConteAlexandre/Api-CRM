<?php
/*
 * This file is part of the YesWeHack JobBoards
 *
 * (c) Guillaume Vassault-Houlière <g.vassaulthouliere@yeswehack.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AbstractFixtures
 */
abstract class AbstractFixtures extends Fixture
{
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->faker = Factory::create();
        $this->propertyAccessor = new PropertyAccessor();
        $this->passwordEncoder = $encoder;
    }
}