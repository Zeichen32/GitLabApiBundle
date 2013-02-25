<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jens
 * Date: 25.02.13
 * Time: 11:26
 * To change this template use File | Settings | File Templates.
 */

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