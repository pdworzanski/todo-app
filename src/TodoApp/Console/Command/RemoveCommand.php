<?php

namespace TodoApp\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityNotFoundException;
use TodoApp\Task\Eraser;

class RemoveCommand extends Command
{
    protected $taskEraser;

    public function __construct(Eraser $taskEraser)
    {
        parent::__construct();
        $this->taskEraser = $taskEraser;
    }

    protected function configure()
    {
        $this
            ->setName('remove')
            ->setDescription('Remove task')
            ->addArgument(
                'ID',
                InputArgument::REQUIRED,
                'ID of the task to remove'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('ID');

        try {
            $this->taskEraser->delete($id);
        } catch (EntityNotFoundException $e) {
            $output->writeln("\n<error>Task with given ID does not exist</error>\n");
            return 1;
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return 2;
        }

        $output->writeln('<info>Task has been removed</info>');
        return 0;
    }
}
