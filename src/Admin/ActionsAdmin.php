<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class ActionsAdmin
 */
class ActionsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('actionType', ModelType::class)
            ->add('description', TextareaType::class)
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('actionType', null, [
                'route' => [
                    'name' => 'show',
                ],
            ])
            ->add('description')
            ->add('user')
            ->add('')
        ;
    }
}