<?php

namespace App\DataFixtures;

use App\Entity\ClientActivity;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ClientActivityFixtures
 */
class ClientActivityFixtures extends AbstractFixtures
{
    const BOUCHER = 'Boucher';
    const BOULANGER = 'Boulanger';
    const CHARCUTIER = 'Charcutier';
    const FLEURISTE = 'Fleuriste';

    const CLIENT_ACTIVITY = [
        self::BOUCHER => [
            'name' => 'Boucher'
        ],
        self::BOULANGER => [
            'name' => 'Boulanger'
        ],
        self::CHARCUTIER => [
            'name' => 'Charcutier'
        ],
        self::FLEURISTE => [
            'name' => 'Fleuriste'
        ]
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadClientActivity($manager);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadClientActivity(ObjectManager $manager)
    {
        foreach (self::CLIENT_ACTIVITY as $id => $data) {
            $clientActivity = new ClientActivity();
            $clientActivity
                ->setName($data['name'])
                ->setEnabled(true);
            $this->setReference($id, $clientActivity);
            $manager->persist($clientActivity);
        }

        $manager->flush();
    }
}