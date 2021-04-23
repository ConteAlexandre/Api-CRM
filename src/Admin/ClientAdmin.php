<?php

namespace App\Admin;

use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ClientAdmin
 */
class ClientAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('clientActivity', ModelType::class, [
                'property' => 'name',
            ])
            ->add('birthday', DateType::class)
            ->add('numberPhone', PhoneNumberType::class, [
                'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
            ])
            ->add('isProspect', CheckboxType::class)
            ->add('isArchived', CheckboxType::class, [
                'required' => false,
            ])
            ->add('enabled', CheckboxType::class)
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('firstName', null, [
                'route' => [
                    'name' => 'show',
                ],
            ])
            ->add('lastName')
            ->add('email')
            ->add('clientActivity')
            ->add('isArchived')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('clientActivity')
            ->add('birthday')
            ->add('phoneNumber')
            ->add('isProspect')
            ->add('isArchived')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('firstName')
            ->add('lastName')
            ->add('isProspect')
        ;
    }
}
