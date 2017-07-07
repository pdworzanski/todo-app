<?php

namespace TodoApp\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TodoApp\Entity\Task;
use TodoApp\Task\Factory;

class AddCommand extends Command
{
    protected $taskFactory;

    public function __construct(Factory $taskFactory)
    {
        parent::__construct();
        $this->taskFactory = $taskFactory;
    }

    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Add new task')
            ->addArgument(
                'text',
                InputArgument::REQUIRED,
                'Text of the new task'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = $input->getArgument('text');
        try {
            $this->taskFactory->create($text);
        } catch (Exception $e) {
            $output->writeln('<error>'. $e->getMessage() .'</error>');
            return 1;
        }

        $output->writeln('<info>Task</info> <comment>"' . $text . '"</comment> <info>has been added</info>');
    }
}
