<?php

namespace TodoApp\Console;

use Symfony\Component\Console\Application;
use Doctrine\Common\Persistence\ObjectManager;
use TodoApp\Console\Command\AddCommand;
use TodoApp\Console\Command\ShowCommand;
use TodoApp\Console\Command\RemoveCommand;
use TodoApp\Console\Command\SetCommand;

class ConsoleApplication extends Application
{
    protected $om;

    public function __construct(ObjectManager $om)
    {
        parent::__construct("Todo Application", "1.0");
        $this->om = $om;
        $this->add(new AddCommand($this->om));
        $this->add(new ShowCommand($this->om));
        $this->add(new RemoveCommand($this->om));
        $this->add(new SetCommand($this->om));
    }
}
