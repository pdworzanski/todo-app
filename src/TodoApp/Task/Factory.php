<?php

namespace TodoApp\Task;

use TodoApp\Entity\Task;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class Factory 
{
    protected $em;

    public function __construct(EntityManagerInterface $entityManger)
    {
        $this->em = $entityManger;
    }

    public function create($text)
    {
        $date = new DateTime();

        if (preg_match("/@[^\\s]+/", $text, $matches, PREG_OFFSET_CAPTURE)) {
            $dateMark = $matches[0][0];
            $dateMarkPos = $matches[0][1];
            $text = substr($text, 0, $dateMarkPos-1) . substr($text, $dateMarkPos+strlen($dateMark));
            $date = new DateTime(substr($dateMark, 1));
        }

        $task = new Task();
        $task->setText($text);
        $task->setDate($date);

        $this->em->persist($task);
        $this->em->flush();
    }
}
