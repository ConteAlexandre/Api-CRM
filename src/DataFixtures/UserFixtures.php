<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use libphonenumber\PhoneNumber;

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
        $passwordMichel = $this->passwordEncoder->encodePassword($michel, 'Michelle1!');
        $phoneNumber = new PhoneNumber();
        $phoneNumber->setCountryCode('33')->setNationalNumber('123456789');

        $dataMichel = [
            'username' => 'Michel',
            'first_name' => 'Michel',
            'last_name' => 'Petit',
            'email' => 'michel@example.com',
            'phone_number' => $phoneNumber,
            'password' => $passwordMichel,
            'salt' => md5(random_bytes(32)),
            'roles' => ['ROLE_ADMIN'],
            'enabled' => true,
        ];

        foreach ($dataMichel as $prop => $value) {
            $this->propertyAccessor->setValue($michel, $prop, $value);
        }
        $this->setReference('user', $michel);

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
            $password = $this->passwordEncoder->encodePassword($user, 'Michelle2!');
            $phoneNumber = new PhoneNumber();
            $phoneNumber->setCountryCode('33')->setNationalNumber('123456789');

            $data = [
                'username' => $this->faker->userName,
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'email' => $this->faker->email,
                'phone_number'=> $phoneNumber,
                'password' => $password,
                'salt' => md5(random_bytes(32)),
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
