<?php

namespace TodoApp\Entity;

/**
 * @Entity
 * @Table(name="task")
 */
class Task
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $text;

    /**
     * @Column(name="is_done", type="boolean", options={"default" = 0})
     */
    protected $isDone = false;

    /**
     * @Column(name="date", type="date")
     */
    protected $date;

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
        return $this;
    }

    public function getIsDone()
    {
        return $this->isDone;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }
}
