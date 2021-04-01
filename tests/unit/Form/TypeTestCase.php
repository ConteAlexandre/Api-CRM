<?php

namespace App\Tests\unit\Form;

use Codeception\Test\Unit;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class TypeTestCase
 */
abstract class TypeTestCase extends Unit
{
    /**
     * @var FormFactoryInterface
     */
    protected $factory;

    /**
     * @var ObjectManager
     */
    protected $em;

    protected $managerRegistryMock;

    protected $routerMock;

    protected $query;

    protected $queryBuiler;


    /**
     * Setup the variable factory before unit test
     */
    public function _before()
    {
        $this->query = $this->createMock(AbstractQuery::class);

        $this->queryBuiler = $this->createMock(QueryBuilder::class);
        $this->queryBuiler->method('where')->willReturnSelf();
        $this->queryBuiler->method('getQuery')->willReturn($this->query);

        $entityRepository = $this->createMock(EntityRepository::class);
        $entityRepository->method('createQueryBuilder')->willReturn($this->queryBuiler);

        $classMetadata = $this->createMock(\Doctrine\ORM\Mapping\ClassMetadata::class);
        $classMetadata->method('getIdentifierFieldNames')->willReturn([]);
        $classMetadata->method('getTypeOfField')->willReturn('integer');
        $classMetadata->method('hasAssociation')->willReturn(false);

        $this->em = $this->createMock(ObjectManager::class);
        $this->em->method('getRepository')->willReturn($entityRepository);
        $this->em->method('getClassMetadata')->willReturn($classMetadata);

        $this->managerRegistryMock = $this->createMock(ManagerRegistry::class);
        $this->routerMock = $this->createMock(RouterInterface::class);

        $this->managerRegistryMock->method('getManagerForClass')->willReturn($this->em);
        $this->managerRegistryMock->method('getManager')->willReturn($this->em);

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addTypeExtensions($this->getTypeExtensions())
            ->addTypes($this->getTypes())
            ->addTypeGuessers($this->getTypeGuessers())
            ->getFormFactory();
    }

    /**
     * @return ValidatorExtension[]
     */
    protected function getExtensions()
    {
        $metadata = new ClassMetadata(Form::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));
        $validator->method('getMetadataFor')->will($this->returnValue($metadata));
        $entityType = new EntityType($this->managerRegistryMock);

        return [
            new ValidatorExtension($validator),
            new PreloadedExtension([$entityType], [])
        ];
    }

    /**
     * @return array
     */
    protected function getTypeExtensions()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getTypeGuessers()
    {
        return [];
    }
}