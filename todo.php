<?php

require_once "bootstrap.php";

$application = new \TodoApp\Console\ConsoleApplication($container);
$application->run();
