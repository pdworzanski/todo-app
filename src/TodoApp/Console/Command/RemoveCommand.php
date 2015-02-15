<?php

namespace TodoApp\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RemoveCommand extends Command
{
    protected $om;

    public function __construct(ObjectManager $om)
    {
        parent::__construct();
        $this->om = $om;
    }

    protected function configure()
    {
        $this
            ->setName('remove')
            ->setDescription('Remove task')
            ->addArgument(
                'ID',
                InputArgument::REQUIRED,
                'ID of task to remove'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('ID');

        $task = $this->om->getRepository('TodoApp\Entity\Task')->find($id);

        if (!$task) {
            $output->writeln('<error>Task with given ID does not exist</error>');
            return 1;
        }

        $this->om->remove($task);
        $this->om->flush();

        $output->writeln('<info>Task has been removed</info>');
    }
}
