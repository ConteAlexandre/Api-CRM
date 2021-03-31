<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserFixtures
 */
class UserFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);

        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {
        $user = new User();
        $password = $this->passwordEncoder->encodePassword($user, 'Michelle2!');

        $data = [
            'username' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $password,
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
