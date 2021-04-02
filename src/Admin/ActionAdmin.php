<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ActionAdmin
 */
class ActionAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('id', null, [
                'route' => [
                    'name' => 'show'
                ]
            ])
            ->add('client')
            ->add('invoice')
            ->add('exchange')
            ->add('devis')
            ->add('createdAt')
            ->add('createdBy')
        ;
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->add('client')
            ->add('invoice')
            ->add('exchange')
            ->add('devis')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('client')
            ->add('invoice')
            ->add('exchange')
            ->add('devis')
        ;
    }
}