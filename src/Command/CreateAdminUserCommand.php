<?php

namespace App\Command;

use App\Entity\AdminUser;
use App\Manager\AdminUserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Class CreateAdminUserCommand
 */
class CreateAdminUserCommand extends Command
{
    protected static $defaultName = 'create:admin:user';

    /**
     * @var AdminUserManager
     */
    protected $adminUserManager;

    /**
     * CreateAdminUserCommand constructor.
     *
     * @param AdminUserManager $manager
     * @param string|null      $name
     */
    public function __construct(AdminUserManager $manager, string $name = null)
    {
        $this->adminUserManager = $manager;
        parent::__construct($name);
    }

    /**
     * Configure arguments
     */
    protected function configure()
    {
        $this
            ->setDescription('Create a new admin user')
            ->setHelp('This command allows you to create an admin user...')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the admin user')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the admin user')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin user password')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $admin = $this->adminUserManager->createAdmin();
        $admin
            ->setUsername($username)
            ->setEmail($email)
            ->setPlainPassword($password)
            ->setEnabled(true)
        ;
        $this->adminUserManager->save($admin);

        $output->write('You are about to ');
        $output->write('create an admin user.');

        return 0;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = [];

        if (!$input->getArgument('username')) {
            $question = new Question('Choose a username: ');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username not empty');
                }

                return $username;
            });
            $questions['username'] = $question;
        }

        if (!$input->getArgument('email')) {
            $question = new Question('Choose a email: ');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email not empty');
                }

                return $email;
            });
            $questions['email'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Choose a password: ');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password not empty');
                }

                return $password;
            });
            $questions['password'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}