<?php

namespace TodoApp\Console\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Helper\TableSeparator;
use TodoApp\Task\Reader;

class ShowCommand extends Command
{
    protected $taskReader;

    public function __construct(Reader $taskReader)
    {
        parent::__construct();
        $this->taskReader = $taskReader;
    }

    protected function configure()
    {
        $this
            ->setName('show')
            ->setDescription('Show tasks')
            ->AddArgument(
                'date',
                InputArgument::OPTIONAL,
                'date filter preceded by @'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $tasks = $this->taskReader->get($input->getArgument('date'));
        } catch (Exception $e) {
            $output->writeln('<error>'. $e->getMessage() .'</error>');
            return 1;
        }

        if ($tasks) {
            $this->printTasks($output, $tasks);
        } else {
            $output->writeln('No tasks found');
        }
    }

    protected function printTasks(OutputInterface $output, $tasks)
    {
        $table = new Table($output);
        $table->setStyle($this->getStyle());
        $table->setHeaders(array('Done', 'ID', 'Date', 'Task'));

        foreach ($tasks as $task) {
            $table->addRow(array(
                ( $task->getIsDone() ) ? '[X]' : '[ ]',
                $task->getId(),
                $task->getDate()->format('Y-m-d'),
                $task->getText()
            ));
            $table->addRow(new TableSeparator());
        }

        $table->render();
    }

    protected function getStyle()
    {
        $style = new TableStyle();
        $style
            ->setHorizontalBorderChar(' ')
            ->setVerticalBorderChar(' ')
            ->setCrossingChar(' ')
        ;
        return $style;
    }
}
