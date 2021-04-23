<?php

namespace App\Manager;

use App\Entity\AdminUser;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminUserManager
 */
class AdminUserManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var AdminUserRepository
     */
    protected $adminUserRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * AdminUserManager constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param AdminUserRepository          $adminUserRepository
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, AdminUserRepository $adminUserRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $entityManager;
        $this->adminUserRepository = $adminUserRepository;
        $this->passwordEncoder = $encoder;
    }

    /**
     * @return AdminUser
     */
    public function createAdmin(): AdminUser
    {
        $admin = new AdminUser();

        return $admin;
    }

    /**
     * @param AdminUser $admin
     *
     * @throws \Exception
     */
    public function updatePassword(AdminUser $admin)
    {
        if (0 != strlen($password = $admin->getPlainPassword())) {
            $admin->setSalt(rtrim(str_replace('*', '.', base64_encode(random_bytes(32))), '='));
            $admin->setPassword($this->passwordEncoder->encodePassword($admin, $admin->getPlainPassword()));
            $admin->eraseCredentials();
        }
    }

    /**
     * @param AdminUser $admin
     * @param bool      $andFlush
     */
    public function save(AdminUser $admin, $andFlush = true)
    {
        $this->updatePassword($admin);

        $this->em->persist($admin);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}