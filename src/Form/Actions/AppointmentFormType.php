<?php


namespace App\Form\Actions;


use App\Entity\Client;

use App\Entity\Exchange;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

/**
 * Class AppointmentFormType
 * @package App\Form\Actions
 */
class AppointmentFormType extends AbstractType
{

    /**
     * @var Security
     */
    private $security;

    /**
     * InvoiceFormType constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->select('r')
                        ->where('r.user = :user')
                        ->setParameter('user', $this->security->getUser());
            },])
            ->add('content', TextareaType::class)
            ->add('type',ChoiceType::class,[
                'multiple' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices'  => [
                    'Telephone' => 'Telephone',
                    'Email' => 'Email',
                    "Rendez-vous clients" => 'rendez-vous clients'
            ],]);

    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exchange::class,
        ]);
    }
}