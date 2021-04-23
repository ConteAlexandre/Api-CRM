<?php

namespace App\Admin;

use App\Entity\ClientActivity;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ClientActivityAdmin
 */
class ClientActivityAdmin extends AbstractAdmin
{
    /**
     * @param object|null $object
     *
     * @return string|null
     */
    public function toString($object)
    {
        return $object instanceof ClientActivity
            ? $object->getName()
            : 'Client Activity : NAME';
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', TextType::class)
            ->add('enabled', CheckboxType::class)
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name', null, [
                'route' =>[
                    'name' => 'show',
                ],
            ])
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('_action', null, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
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
            ->add('name')
            ->add('enabled')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }
}