<?php
/**
 * Created by PhpStorm.
 * User: camille
 * Date: 02/04/2021
 * Time: 09:55
 */

namespace App\Form\Account;

use App\Entity\User;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProfileFormType
 * @package App\Form\Account
 */
class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('phoneNumber', PhoneNumberType::class, [
                'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => User::class
            ]);
    }

}