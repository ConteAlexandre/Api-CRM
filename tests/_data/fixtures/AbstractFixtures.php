<?php

namespace App\Tests\_data\fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PropertyAccess\PropertyAccessor;

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
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * AbstractFixtures constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create();
        $this->propertyAccessor = new PropertyAccessor();
    }
}