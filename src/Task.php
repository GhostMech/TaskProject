<?php
namespace GMH;

require_once 'CollectionItem.php';

use DateTime;
use Exception;

class Task extends CollectionItem
{
    /**
     * The due date of the task.
     *
     * @var string
     */
    protected $dueDate;

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
}
