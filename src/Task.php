<?php
namespace GMH;

require_once 'TaskInterface.php';

use DateTime;
use Exception;

class Task implements TaskInterface
{
    /**
     * The id number of the task.
     *
     * @var int
     */
    private $id;

    /**
     * The name of the task.
     *
     * @var string
     */
    private $name;

    /**
     * The due date of the task.
     *
     * @var string
     */
    private $dueDate;

    private function validateString($string)
    {
        try {
            if (! is_string($string)) {
                throw new Exception('ERROR: Task name must be a string.'); 
            }
            return $string;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Set the task name.
     * Returns the object for method chaining.
     *
     * @param string $taskName
     * @return \GMH\Task
     */
    public function name($taskName)
    {
        $this->name = $this->validateString($taskName);
        return $this;
    }

    /**
     * Set the task's due date.
     * Returns the object for method chaining.
     *
     * @param string $dateString
     * @return \GMH\Task
     */
    public function dueDate($dateString)
    {
        $this->dueDate = $this->validateString($dateString);
        return $this;
    }

    /**
     * Gets the task's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the due date of the task.
     *
     * @return string
     */
    public function getDueDate() 
    {
        if (class_exists('\Carbon\Carbon')) {
            return new \Carbon\Carbon($this->dueDate);
        }
        return new DateTime($this->dueDate);
    }

    /**
     * Gets the task id number.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the task id number.
     *
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }
}
