<?php
namespace GMH;

require_once 'Task.php';

require_once 'DBInsertException.php';

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

    public function __construct(StorageInterface $storage)
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
        try {
            $this->dbInsert($task);
            $this->getAllTasks();
            return $this;
        } catch (DBInsertException $e) {
            echo $e->getMessage();
        }
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
        $removedTask = $this->removeTaskFromDb($id);
        $this->getAllTasks();
        return $removedTask;
    }

    /**
     * Removes a task from the database.
     *
     * @param mixed $id
     * @return void
     */
    private function removeTaskFromDb($id)
    {
        try {
            $stmt1 = $this->pdo->prepare("SELECT id, name, due_date as dueDate FROM tasks WHERE id=:id");
            $stmt1->setFetchMode(\PDO::FETCH_CLASS, '\GMH\Task');
            $stmt1->execute([':id' => $id]);
            $removedTask = $stmt1->fetch();

            var_dump($removedTask);

            $stmt2 = $this->pdo->prepare("DELETE FROM tasks WHERE id=:id");
            $stmt2->execute([':id' => $id]);
            return $removedTask;
        } catch (\PDOException $e) {
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
        if (isset($this->tasks)) {
            $this->tasks = [];
        }
        $sql = 'SELECT id, name, due_date as dueDate FROM tasks';
        $stmt = $this->pdo->prepare($sql);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\GMH\Task');
        $stmt->execute();

        while ($task = $stmt->fetch()) {
            $this->tasks[] = $task;
        }
        return $this->tasks;
    }

    /**
     * Inserts a task into the database.
     *
     * @param \GMH\Task $task
     * @return void
     */
    private function dbInsert(Task $task)
    {
        if (is_null($task->getId())) {
            $sql = "INSERT INTO tasks values(null, :name, :dueDate)";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $task->getName(), ':dueDate' => $task->getDueDate()]);
    }

    public function first()
    {
        $tasks = $this->getAllTasks();
        return array_shift($tasks);
    }
}
