<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\AdminUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * AdminUserManager constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param AdminUserRepository          $userUserRepository
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, AdminUserRepository $userUserRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $entityManager;
        $this->userRepository = $userUserRepository;
        $this->passwordEncoder = $encoder;
    }

    /**
     * @return User
     */
    public function createAdmin(): User
    {
        $user = new User();

        return $user;
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     */
    public function updatePassword(User $user)
    {
        if (0 != strlen($password = $user->getPlainPassword())) {
            $user->setSalt(rtrim(str_replace('*', '.', base64_encode(random_bytes(32))), '='));
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            $user->eraseCredentials();
        }
    }

    /**
     * @param User $user
     * @param bool $andFlush
     *
     * @throws \Exception
     */
    public function save(User $user, $andFlush = true)
    {
        $this->updatePassword($user);

        $this->em->persist($user);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}