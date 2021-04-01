<?php

namespace App\Tests\unit\Form;

use App\Entity\Client;
use App\Form\Account\RegisterClientFormType;
use libphonenumber\PhoneNumber;

/**
 * Class RegisterClientFormTypeTest
 */
class RegisterClientFormTypeTest extends TypeTestCase
{
    /**
     * Test the submit of the form
     */
    public function testSubmit()
    {
        $client = new Client();
        $birthday = new \DateTime('now');
        $phoneNumber = new PhoneNumber();
        $phoneNumber->setCountryCode('33')->setNationalNumber('658964212');

        $formData = [
            'firstName' => 'Jean',
            'lastName' => 'Petit',
            'email' => 'jean@example.com',
            'numberPhone' => $phoneNumber,
            'birthday' => $birthday->format('Y-m-d'),
        ];

        $form = $this->factory->create(RegisterClientFormType::class, $client);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame('Jean', $client->getFirstName());
        $this->assertSame('Petit', $client->getLastName());
        $this->assertSame('jean@example.com', $client->getEmail());
    }
}