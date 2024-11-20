<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsCommand(
    name: 'app:create-user',
    description: 'Add a short description for your command',
)]
class CreateUserCommand extends Command
{
    private $entityManager;
    private $passwordHasher;
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create a user with specific roles')
            ->setHelp('This command allows you to create a user with ROLE_ADMIN and ROLE_MEMBRE');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Ask for email and password for the new user
        $email = 'user@admin.com'; // Change as needed
        $password = 'password'; // Change as needed

        // Create a new user
        $user = new User();
        $user->setEmail($email);

        // Encode the password
        // $encodedPassword = $this->passwordEncoder->encodePassword($user, $password);
        // $user->setPassword($encodedPassword);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashedPassword);


        // Set roles
        $user->setRoles(['ROLE_ADMIN']);

        // Persist the user entity
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('User created successfully with roles ROLE_ADMIN and ROLE_MEMBRE.');

        return Command::SUCCESS;
    }
}
