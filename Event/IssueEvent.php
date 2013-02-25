<?php
namespace Zeichen32\GitLabApiBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class IssueEvent extends Event {

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
}