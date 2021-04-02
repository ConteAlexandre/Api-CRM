<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ActionsAdmin
 */
class ActionsAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('title', TextType::class)
            ->add('actionType', ModelType::class, [
                'property' => 'name',
            ])
            ->add('description', TextareaType::class)
            ->add('user', ModelType::class, [
                'property' => 'username',
            ])
            ->add('client', ModelType::class, [
                'property' => 'firstName',
            ])
            ->add('invoice', ModelType::class, [
                'property' => 'reference',
            ])
            ->add('devis', ModelType::class, [
                'property' => 'reference',
            ])
            ->add('exchange', ModelType::class, [
                'property' => 'title',
            ])
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('title', null, [
                'route' => [
                    'name' => 'show',
                ],
            ])
            ->add('actionType')
            ->add('description')
            ->add('user')
            ->add('client')
            ->add('invoice')
            ->add('devis')
            ->add('exchange')
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
            ->add('title')
            ->add('actionType')
            ->add('description')
            ->add('user')
            ->add('client')
            ->add('invoice')
            ->add('devis')
            ->add('exchange')
        ;
    }
}