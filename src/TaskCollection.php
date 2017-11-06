<?php

namespace GMH;

use \PDO;
use \PDOException;
use GMH\DbInsertException;
use GMH\DbSelectException;
use GMH\DbDeleteException;
use GMH\TaskInterface;

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

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
            $this->dbInsert($task);

            return $this;
        } catch (DBInsertException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get the "last inserted" id number from the database.
     *
     * @return string
     */
    public function getIdFromDb()
    {
        try {
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove a task from the collection.
     *
     * @param int $id
     *
     * @return void
     */
    public function removeTask($id)
    {
        $removedTask = $this->removeTaskFromDb($id);
        $this->getAllTasks();

        return $removedTask;
    }

    /**
     * Remove a task from the database.
     *
     * @param mixed $id
     *
     * @return void
     */
    private function removeTaskFromDb($id)
    {
        try {
            $stmt1 = $this->pdo->prepare('SELECT id, name, due_date as dueDate FROM tasks WHERE id=:id');
            $stmt1->setFetchMode(\PDO::FETCH_CLASS, '\GMH\Task');
            $stmt1->execute([':id' => $id]);
            $removedTask = $stmt1->fetch();

            $stmt2 = $this->pdo->prepare('DELETE FROM tasks WHERE id=:id');
            $stmt2->execute([':id' => $id]);

            return $removedTask;
        } catch (DbDeleteException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get all of the tasks to be done.
     *
     * @return array
     */
    public function getAllTasks()
    {
        $this->tasks = $this->dbSelect($fields = ['id', 'name', 'due_date']);
    }

    private function dbSelect(array $fields)
    {
        try {
            $results = [];
            $sql = 'SELECT id, name, due_date as dueDate FROM tasks';
            $stmt = $this->pdo->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, '\GMH\Task');
            $stmt->execute();

            while ($task = $stmt->fetch()) {
                $results[] = $task;
            }

            return $results;
        } catch (DbSelectException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Insert a task into the database.
     *
     * @param \GMH\Task $task
     *
     * @return void
     */
    private function dbInsert(TaskInterface $task)
    {
        try {
            if (is_null($task->getId())) {
                $sql = 'INSERT INTO tasks values(null, :name, :dueDate)';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    
                    ':name' => $task->getName(), 
                    ':dueDate' => $task->getDueDate()
                ]);
            }
        } catch (DbInsertException $e) {
            echo $e->getMessage;
        }
    }
}
