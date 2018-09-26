<?php
/**
 * User: alexiy
 * Date: 1/28/18
 * Time: 3:12 PM
 */

namespace alexiy;


class Set
{
    public $array;

    function __construct(array $data=array())
    {
        $this->array=array_unique($data);
    }

    function getItem(int $index)
    {
        return $this->array[$index];
    }

    function add($value)
    {
        array_push($this->array,$value);
        $this->array=array_unique($this->array);
    }
}