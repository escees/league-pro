<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    const NAME = 'app:create:user';

    private $entityManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, ?string $name = null)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;

        parent::__construct(self::NAME);
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Creating user...</info>');

        $user = new User();
        $user->setEmail($input->getArgument('email'));
        $user->setPassword($this->passwordEncoder->encodePassword($user, $input->getArgument('password')));
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $output->writeln('<info>Saving...</info>');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('<info>User successfully created!</info>');
    }
}