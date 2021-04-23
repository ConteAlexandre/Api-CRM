<?php

namespace App\Tests\_data\fixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

/**
 * Class UserFixtures
 */
class UserFixtures extends AbstractFixtures
{
    const NUMBER_USER = 10;

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadMichel($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function loadMichel(ObjectManager $manager)
    {
        $michel = new User();
        $encoder = new PlaintextPasswordEncoder();

        $dataMichel = [
            'username' => 'Michel',
            'first_name' => 'Michel',
            'last_name' => 'Petit',
            'email' => 'michel@example.com',
            'password' => $encoder->encodePassword('Michelle1!', ''),
            'salt' => md5(random_bytes(32)),
            'is_archived' => false,
            'roles' => ['ROLE_USER'],
            'enabled' => true,
        ];

        foreach ($dataMichel as $prop => $value) {
            $this->propertyAccessor->setValue($michel, $prop, $value);
        }

        $manager->persist($michel);
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function loadUser(ObjectManager $manager)
    {
        for ($i = 0; $i < self::NUMBER_USER; $i++) {
            $user = new User();
            $encoder = new PlaintextPasswordEncoder();

            $data = [
                'username' => $this->faker->userName,
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'email' => $this->faker->email,
                'password' => $encoder->encodePassword('Michelle2!', ''),
                'salt' => md5(random_bytes(32)),
                'is_archived' => false,
                'roles' => ['ROLE_USER'],
                'enabled' => true,
            ];

            foreach ($data as $prop => $value) {
                $this->propertyAccessor->setValue($user, $prop, $value);
            }

            $manager->persist($user);
        }
    }
}