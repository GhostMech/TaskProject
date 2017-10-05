<?php
namespace GMH;

interface TaskInterface
{
    /**
     * Get the name of the task
     *
     * @return string
     */
    public function getName();

    /**
     * Get the task's due date.
     *
     * @return string
     */
    public function getDueDate();
}
