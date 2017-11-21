<?php

namespace GMH;

use \Countable;
use GMH\DbInsertException;
use GMH\DbSelectException;
use GMH\DbDeleteException;
use GMH\TaskInterface;

class TaskCollection implements Countable
{
    /**
     * All of the \GMH\Task objects.
     *
     * @var array
     */
    private $tasks = [];

    /**
     * The storage for the tasks.
     *
     * @var GMH/StorageInterface instance
     */
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Returns the number of tasks.
     *
     * @return int
     */
    public function count()
    {
        return count($this->tasks);
    }

    /**
     * Add a task to the collection.
     * Returns the object for method chaining.
     *
     * @param TaskInterface $task
     *
     * @return \GMH\TaskCollection
     */
    public function addTask(TaskInterface $task)
    {
        try {
            $taskArray = [];
            $taskArray['id'] = $task->getId();
            $taskArray['name'] = $task->getName();
            $taskArray['dueDate'] = $task->getDueDate();

            if ($this->storage->create($taskArray)) {
                return $this;
            } else {
                throw new DbInsertException('ERROR: Could not create the new task');
            }
        } catch (DBInsertException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get the "last inserted" id number from the database.
     *
     * @return string
     */

    /**
     * Remove a task from the collection.
     *
     * @param int $id
     *
     * @return boolean
     */
    public function deleteTask($id)
    {
        if (is_int($id)) {
            $wasDeleted = $this->storage->delete($id);
            $this->getAllTasks();

            return $wasDeleted;
        }
    }

    /**
     * Get all of the tasks to be done.
     *
     * @return array
     */
    public function getAllTasks()
    {
        $this->tasks = $this->storage->read();

        return $this->tasks;
    }
}
