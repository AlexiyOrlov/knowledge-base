<?php
/**
 * Created by PhpStorm.
 * User: alexiy
 * Date: 1/24/18
 * Time: 8:56 PM
 */

namespace alexiy;


class Group
{
    private $createTopics, $editTopics, $deleteTopics;
    private $createComents, $editcomments, $deleteComments;
    public function __construct(bool $canDeleteTopics)
    {
        $this->deleteTopics=$canDeleteTopics;
    }




}