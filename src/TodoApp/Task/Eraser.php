<?php

namespace TodoApp\Task;

use TodoApp\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;

class Eraser 
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->em = $entityManger;
    }

    public function delete($taskId)
    {
        $task = $this->em->getRepository('TodoApp\Entity\Task')->find($taskId);

        if (!$task) {
            throw new EntityNotFoundException();
        }

        $this->em->remove($task);
        $this->em->flush();
    }
}
