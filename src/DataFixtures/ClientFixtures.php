<?php


namespace App\DataFixtures;


use App\Entity\Client;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ClientFixtures
 * @package App\DataFixtures
 */
class ClientFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    const NUMBER_CLIENT = 20;

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->loadClient($manager);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function loadClient(ObjectManager $manager)
    {

        for ($i = 0; $i < self::NUMBER_CLIENT; $i++) {
            $client = new Client();
            $data = [
                'firstName'=> $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'email' => $this->faker->email,
                'birthday'=> $this->faker->dateTime,
                'numberPhone'=> $this->faker->phoneNumber,
                'isProspect'=> $this->faker->boolean(),
                'user' => $this->getReference('user'),
                'is_archived' => false,
                'enabled' => true,
            ];

            foreach ($data as $prop => $value) {
                $this->propertyAccessor->setValue($client, $prop, $value);
            }

            $manager->persist($client);
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}