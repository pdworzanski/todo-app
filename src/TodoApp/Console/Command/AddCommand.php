<?php

namespace TodoApp\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TodoApp\Entity\Task;

class AddCommand extends Command
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
        $date = new \DateTime();

        if (preg_match("/@[^\\s]+/", $text, $matches, PREG_OFFSET_CAPTURE)) {
            $dateMark = $matches[0][0];
            $dateMarkPos = $matches[0][1];
            $text = substr($text, 0, $dateMarkPos-1) . substr($text, $dateMarkPos+strlen($dateMark));
            try {
                $date = new \DateTime(substr($dateMark, 1));
            } catch (\Exception $e) {
                $output->writeln('<error>Ivalid date mark "'. $dateMark .'"</error>');
                return 1;
            }
        }

        $task = new Task();
        $task->setText($text);
        $task->setDate($date);

        $this->om->persist($task);
        $this->om->flush();

        $output->writeln('<info>Task</info> <comment>"' . $text . '"</comment> <info>has been added</info>');
    }
}
