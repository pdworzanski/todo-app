<?php

require "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

if (!file_exists('parameters.yml')) {
    echo "Database configuration not found. Please run composer install|update first\n";
    exit(1);
}

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), false);

$yaml = new Parser();
try {
    $parameters = $yaml->parse(file_get_contents('parameters.yml'));
} catch (ParseException $e) {
    echo "Unable to parse the YAML parameters file: " . $e->getMessage() ."\n";
    exit(1);
}

$entityManager = EntityManager::create($parameters['database'], $config);
