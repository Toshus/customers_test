<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\UserLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCustomers extends Command
{
    protected static $defaultName = 'app:customers:load';
    
    private UserLoader $userLoader;
    
    public function __construct(UserLoader $userLoader, string $name = null)
    {
        $this->userLoader = $userLoader;
        parent::__construct($name);
    }
    
    protected function configure()
    {
        $this->setDescription('Loads customers from randomuser API');
        $this->addArgument('results', InputArgument::OPTIONAL, 'Users count to load');
        $this->addArgument('nat', InputArgument::OPTIONAL, 'User\'s nationality');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start loading customers');
        
        $results = $input->getArgument('results') ?? 100;
        $nat = $input->getArgument('nat') ?? 'AU';
        
        $this->userLoader->loadUsers(compact('results', 'nat'));
        
        $output->writeln('Customers successfully loaded');
        return Command::SUCCESS;
    }
}