<?php

namespace TodoApp\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TodoApp\Task\Setter;
use InvalidArgumentException;
use Doctrine\ORM\EntityNotFoundException;

class SetCommand extends Command
{
    protected $taskSetter;

    public function __construct(Setter $taskSetter)
    {
        parent::__construct();
        $this->taskSetter = $taskSetter;
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

        try {
            $this->taskSetter->setStatus($id, $status);
        } catch (InvalidArgumentException $e) {
            $output->writeln('<error>Invalid status. Use: done|undone"</error>');
            return 1;
        } catch (EntityNotFoundException $e) {
            $output->writeln('<error>Task with given ID does not exist</error>');
            return 2;
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 3;
        }

        $output->writeln('Task <comment>#'. $id .'</comment> has been marked as <info>'. $status .'</info>');
    }
}
