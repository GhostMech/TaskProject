<?php
namespace GMH;

require_once 'StorageInterface.php';
require_once 'Task.php';

class PdoStorage implements StorageInterface
{   
    private $pdo;

    public function __construct(array $credentials)
    {
        foreach ($credentials as $key => $cred) {
            $credentials[$key] = trim($cred);
        }
        $count = count($credentials);
        if ($count < 2 || $count < 3) {
            $credentials = array_pad($credentials, 3, '');
        }
        $this->pdo = new \PDO($credentials[0], $credentials[1], $credentials[2]);
    }

    public function create($item)
    {
        $stmt = $this->pdo->prepare('REPLACE INTO tasks values(null, :name, :due_date)');
        $stmt->execute([':name' => $item->getName(), ':due_date' => $item->getDueDate()]);

        return $this->pdo->lastInsertId();
    }

    public function read($id)
    {
        $stmt = $this->pdo->prepare('SELECT id, name, due_date as dueDate FROM tasks WHERE id=:id');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, \GMH\Task::class);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();

    }

    public function update($item)
    {
        //
    }

    public function delete($id)
    {
        $removedItem = $this->read($id);
        $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id=:id limit 1');
        $stmt->execute([':id' => $id]);

        return $removedItem;
    }

    public function all()
    {
        $stmt = $this->pdo->prepare('SELECT id, name, due_date as dueDate FROM tasks');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\GMH\Task');
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
