<?php
namespace GMH;

require_once 'Collection.php';
require_once '../vendor/autoload.php';

use GMH\Collection;

class TaskCollection extends Collection implements \Countable
{
    /**
     * Returns the number of tasks.
     *
     * @return integer
     */
    public function count()
    {
        $this->all();
        return count($this->items);
    }

    /**
     * Adds a task to the collection.
     * Returns the object for method chaining.
     *
     * @param TaskInterface $task
     * @return \GMH\TaskCollection
     */
    public function addTask(Task $task)
    {
        $this->storage->create($task);
        $this->all();

        return $this;
    }

    /**
     * Gets the "last inserted" id number from the database.
     *
     * @return string
     */
    public function getIdFromDb()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Remove a task.
     *
     * @param integer $id
     * @return void
     */
    public function removeTask($id)
    {
        $removedTask = $this->storage->delete($id);
        return $removedTask;
    }

    /**
     * Get all of the tasks to be done.
     *
     * @return array
     */
    public function all()
    {   
        $this->items = $this->storage->all();
        return $this->items;
    }

    /**
     * Gets the first task in the collection.
     *
     * @return \GMH\Task
     */
    public function first()
    {
        $this->items = $this->all();

        return array_values($this->items)[0];
    }

    public function last()
    {
        $this->items = $this->all();

        $values = array_values($this->items);
        return array_pop($values);
    }
}
