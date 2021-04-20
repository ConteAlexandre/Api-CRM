<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class InvoiceAdmin
 */
class InvoiceAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('send', $this->getRouterIdParameter().'/send');
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('reference', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', NumberType::class)
            ->add('user', ModelType::class, [
                'property' => 'username'
            ])
            ->add('enabled')
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('reference', null, [
                'route' => [
                    'name' => 'show',
                ],
            ])
            ->add('price')
            ->add('user')
            ->add('createdAt')
            ->add('createdBy')
            ->add('enabled')
            ->add('_action', null, [
                'actions' => [
                    'send' => [
                        'template' => 'admin/CRUD/list_action_send.html.twig',
                    ],
                ],
            ])
        ;
    }

    /**
     * @param ShowMapper $show
     */
    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('reference')
            ->add('description')
            ->add('price')
            ->add('user')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('enabled')
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('reference')
            ->add('user')
            ->add('price')
        ;
    }
}