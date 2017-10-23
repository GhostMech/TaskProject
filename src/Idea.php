<?php
namespace GMH;

class Idea
{
    protected $name;
    protected $number = 3;

    public function __get($property)
    {
        $method = "get{$property}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return;
    }

    public function __set($property, $value)
    {
        $method = "set{$property}";
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }

    public function __call($methodName, $args)
    {
        $method = "set{$methodName}";

        if (method_exists($this, $method)) {
            return $this->$method( func_get_args()[1][0] );
        }
    }

    public function whatClass()
    {
        return  get_class();
    }


    protected function getName()
    {
        return $this->name;
    }

    protected function getNumber()
    {
        return $this->number;
    }

    protected function setName($name)
    {
        if (is_string($name)) {
            $name = trim($name);
            if (strlen($name) > 0) {
                $this->name = $name;
            }
        }
        return $this;
    }

    protected function setNumber($number)
    {
        if (is_numeric($number)) {
            $this->number = (int)$number;
        }
        return $this;
    }
}