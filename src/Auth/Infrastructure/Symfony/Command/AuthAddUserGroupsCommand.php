<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Symfony\Command;

use App\Auth\Domain\User;
use App\Auth\Infrastructure\Persistence\UserRepository;
use App\Household\Groups\Infrastructure\Persistence\GroupRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'auth:user:add-groups',
    description: 'Adds user',
)]
final class AuthAddUserGroupsCommand extends Command
{
    public function __construct(
        private GroupRepository $groupRepository,
        private UserRepository $userRepository,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    public function configure(): void
    {
        $this
            ->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'Username of the user (email)')
            ->addOption('groups', 'g', InputOption::VALUE_REQUIRED, 'Groups that user has to belong')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $user = $this->userRepository->findOneBy(['email' => $input->getOption('username')]);
            $groupsAddedCount = $this->addGroupsToUser($input->getOption('groups'), $user);
        } catch (Throwable $e) {
            $io->error(['Failed to add groups for user', (string) $e]);

            return Command::FAILURE;
        }

        $io->success(sprintf('Successfuly added %d groups to the user', $groupsAddedCount));

        return Command::SUCCESS;
    }

    private function addGroupsToUser(string $groupNames, User $user): int
    {
        $groupNames = explode(', ', $groupNames);
        $groups = $this->groupRepository->findBy(['name' => $groupNames]);

        foreach ($groups as $group) {
            $user->addUserGroup($group);
        }

        return count($groups);
    }
}
