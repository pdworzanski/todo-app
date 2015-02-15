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

class ShowCommand extends Command
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
        $dateMark = $input->getArgument('date');
        if ($dateMark) {
            try {
                $date = new \DateTime(substr($dateMark, 1));
                $tasks = $this->om->getRepository('TodoApp\Entity\Task')->findBy(array(
                    'date' => $date
                ));
            } catch (\Exception $e) {
                $output->writeln('<error>Ivalid date mark "'. $dateMark .'"</error>');
                return 1;
            }
        } else {
            $tasks = $this->om->getRepository('TodoApp\Entity\Task')->findAll();
        }

        if ($tasks) {
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
        } else {
            $output->writeln('No tasks found');
        }
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
