<?php

namespace Employee\Command;

use Employee\Service\RemoveEmployeeService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:employee:remove',
    description: 'Remove an employee from the system',
    aliases: ['app:employee-remove'],
    hidden: false
)]
class RemoveEmployeeCommand extends Command
{

    public function __construct(
        private readonly RemoveEmployeeService $removeEmployeeService
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'The employee email');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');

        $this->removeEmployeeService->remove($email);

        $output->writeln(sprintf('Employee with email [%s] has been removed', $email));

        return Command::SUCCESS;
    }
}
