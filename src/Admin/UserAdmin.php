<?php

namespace App\Admin;

use App\Manager\UserManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class UserAdmin
 */
class UserAdmin extends AbstractAdmin
{
    /**
     * @var UserManager
     */
    protected $userManager;

    public function __construct($code, $class, string $baseControllerName, UserManager $userManager)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->userManager = $userManager;
    }

    /**
     * @param object $object
     *
     * @throws \Exception
     */
    public function preUpdate($object)
    {
        $this->userManager->updatePassword($object);
    }

    /**
     * @param object $object
     *
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $this->userManager->updatePassword($object);
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('username', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, [
                'required' => false,
            ])
            ->add('isArchived', CheckboxType::class, [
                'required' => false,
            ])
            ->add('enabled', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('username', null, [
                'routes' => [
                    'name' => 'show',
                ],
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('roles')
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
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('roles')
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
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('enabled')
            ->add('isArchived')
        ;
    }
}