<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Invoice;
use App\Form\DataMapper\CustomPropertyPathMapper;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class InvoiceFormType
 */
class InvoiceFormType extends AbstractType
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
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setDataMapper(new CustomPropertyPathMapper())
            ->add('filename', FileType::class, [
                'label' => 'Invoice (PDF file)',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('r')
                        ->select('r.firstName')
                        ->where('r.user = :user')
                        ->setParameter('user', $this->security->getUser());
                }
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}