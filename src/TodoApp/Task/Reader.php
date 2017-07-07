<?php

namespace TodoApp\Task;

use TodoApp\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class Reader 
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->em = $entityManger;
    }

    public function get($dateMark = null)
    {
        if ($dateMark) {
            $date = new DateTime(substr($dateMark, 1));
            $tasks = $this->em->getRepository('TodoApp\Entity\Task')->findByDate($date);
        } else {
            $tasks = $this->em->getRepository('TodoApp\Entity\Task')->findAll();
        }

        return $tasks;
    }
}
