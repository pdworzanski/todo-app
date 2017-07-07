<?php

namespace TodoApp\Task;

use TodoApp\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;

class Setter 
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->em = $entityManger;
    }

    public function setStatus($taskId, $status)
    {
        if (!in_array($status, ['done', 'undone'])) {
            throw new InvalidArgumentException();
        }

        $task = $this->em->getRepository('TodoApp\Entity\Task')->find($taskId);

        if (!$task) {
            throw new EntityNotFoundException();
        }

        $isDone = ($status == 'done') ? true : false;
        $task->setIsDone($isDone);
        $this->em->flush();

        return $task;
    }
}
