<?php

namespace TodoApp\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SetCommand extends Command
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
            ->setName('set')
            ->setDescription('Change status of the task')
            ->addArgument(
                'ID',
                InputArgument::REQUIRED,
                'ID of task'
            )
            ->addArgument(
                'status',
                InputArgument::REQUIRED,
                'New status of the task. Allowed values are done|undone'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('ID');
        $status = $input->getArgument('status');

        $task = $this->om->getRepository('TodoApp\Entity\Task')->find($id);

        if (!$task) {
            $output->writeln('<error>Task with given ID does not exist</error>');
            return 1;
        }

        if (!in_array($status, array('done', 'undone'))) {
            $output->writeln('<error>Invalid status. Allowed statuses are done|undone"</error>');
            return 1;
        }

        $isDone = ($status == 'done') ? true : false;
        $task->setIsDone($isDone);
        $this->om->flush();

        $output->writeln('<info>Task #'. $id .' has been marked as '. $status .'</info>');
    }
}
