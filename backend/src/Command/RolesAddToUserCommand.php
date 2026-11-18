<?php

namespace App\Command;

use App\Component\User\UserManager;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'roles:add-to-user',
    description: 'Add a Role to a User',
    aliases: ['r:add']
)]
class RolesAddToUserCommand extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserManager $userManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $idQuestion = new Question('Enter ID: ');
        $roleQuestion = new Question('Enter Role: ');
        $questionHelper = $this->getHelper('question');

        $user = null;
        $role = null;
        $id = null;

        while(!$user){
            while(!$id) {
                $id = $questionHelper->ask($input, $output, $idQuestion);

                if(!$id) {
                    $io->warning("ID is required");
                }
            }

            $user = $this->userRepository->find($id);

            if(!$user) {
                $io->warning("No User found with ID {$id}");
                exit();
            }
        }

        while(!$role)
        {
            $role = $questionHelper->ask($input, $output, $roleQuestion);

            if(!$role) {
                $io->warning("ROLE is required");
            }
        }

        if ($user->getRole()) {

            $roles = $user->getRole();

            if(in_array($role, $roles, true)){
                $io->warning("User already has {$role}");
                return Command::SUCCESS;
            }

            $roles[] = $role;

            $user->setRole($roles);
            $this->userManager->save($user, true);

            $io->success("Role {$role} has been added to user");
        }


        return Command::SUCCESS;
    }
}
