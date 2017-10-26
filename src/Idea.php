<?php

namespace GMH;

class Idea
{
    /**
     * The idea name.
     *
     * @var string
     */
    protected $name;

    /**
     * The number of the idea.
     *
     * @var int
     */
    protected $number = 3;

    /**
     * Gets a non-public property of the object.
     *
     * @param string $property
     *
     * @return void
     */
    public function __get($property)
    {
        $method = "get{$property}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }
    }

    /**
     * Sets a non-public property of the object.
     *
     * @param string $property
     * @param mixed  $value
     */
    public function __set($property, $value)
    {
        $method = "set{$property}";
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
    }

    /**
     * Calls a non-public method of the object.
     *
     * @param string $methodName
     * @param mixed  $args
     *
     * @return void
     */
    public function __call($methodName, $args)
    {
        $method = "set{$methodName}";

        if (method_exists($this, $method)) {
            return $this->$method(func_get_args()[1][0]);
        }
    }

    /**
     * Returns the fully-qualified class name.
     *
     * @return void
     */
    public function whatClass()
    {
        return  get_class();
    }

    /**
     * Returns the name of the idea.
     *
     * @return string
     */
    protected function getName()
    {
        return $this->name;
    }

    /**
     * Returns the number of the idea.
     *
     * @return int
     */
    protected function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the name of the idea.
     * Returns the object for method chaining.
     *
     * @param string $name
     *
     * @return \GMH\Idea
     */
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

    /**
     * Sets the number of the idea.
     * Returns the object for method chaining.
     *
     * @param int $number
     *
     * @return \GMH\Idea
     */
    protected function setNumber($number)
    {
        if (is_numeric($number)) {
            $this->number = (int) $number;
        }

        return $this;
    }
}
