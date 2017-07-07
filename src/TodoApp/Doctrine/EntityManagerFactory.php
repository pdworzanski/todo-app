<?php

namespace TodoApp\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class EntityManagerFactory 
{
    public static function create($dbParams)
    {
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__."/../../../src"], false);

        return EntityManager::create($dbParams, $config);
    }
}
