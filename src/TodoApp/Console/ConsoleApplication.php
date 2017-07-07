<?php

namespace TodoApp\Console;

use Symfony\Component\Console\Application;
use TodoApp\Console\Command\AddCommand;
use TodoApp\Console\Command\ShowCommand;
use TodoApp\Console\Command\RemoveCommand;
use TodoApp\Console\Command\SetCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConsoleApplication extends Application
{
    protected $container;

    public function __construct(ContainerBuilder $container)
    {
        parent::__construct("Todo Application", "1.0");

        $this->container = $container;

        $this->add(new AddCommand($this->container->get('task.factory')));
        $this->add(new ShowCommand($this->container->get('task.reader')));
        $this->add(new RemoveCommand($this->container->get('task.eraser')));
        $this->add(new SetCommand($this->container->get('task.setter')));

    }
}
