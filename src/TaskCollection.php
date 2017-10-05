<?php
namespace GMH;

require_once 'Task.php';

use Exception;

//\set_error_handler(function (){ echo 'There was errorz'; });

class TaskCollection implements \Countable
{
    /**
     * All of the \GMH\Task objects.
     *
     * @var array
     */
    private $tasks = [];

    /**
     * The PDO connection to the database.
     *
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Returns the number of tasks.
     *
     * @return integer
     */
    public function count()
    {
        return count($this->tasks);
    }

    /**
     * Adds a task to the collection.
     * Returns the object for method chaining.
     *
     * @param TaskInterface $task
     * @return \GMH\TaskCollection
     */
    public function addTask(TaskInterface $task)
    {
        $this->dbInsert($task);
        $task->setId($this->getIdFromDb());
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Gets the "last inserted" id number from the database.
     *
     * @return string
     */
    private function getIdFromDb()
    {
        return $this->pdo->lastInsertId();
    }

    public function removeTask($id)
    {
        if (in_array($id, array_keys($this->tasks))) {
            $removedTask = $this->tasks[$id];
            unset($this->tasks[$id]);

            return $removedTask;
        }
        return;
    }

    private function dbInsert($task)
    {
        $sql = "INSERT INTO tasks values(null, :name, :dueDate)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $task->getName(), ':dueDate' => $task->getDueDate()]);
    }
}
