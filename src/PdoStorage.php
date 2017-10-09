<?php
namespace GMH;

require_once 'StorageInterface.php';

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
        //
    }

    public function read($id)
    {
        //
    }

    public function update($item)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
