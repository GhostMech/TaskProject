<?php
/**
 * Created by PhpStorm.
 * User: garyhowardpctech@yahoo.com
 * Date: 11/20/2017
 * Time: 6:54 PM
 */

namespace GMH;

use Countable;

class JsonStorage implements StorageInterface, Countable
{
    private $sourceFile;

    private $jsonString;

    private $jsonArray = [];

    /**
     * JsonStorage constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        if (is_file($filename) && file_exists($filename)) {
            $this->sourceFile = $filename;
            $this->jsonString = file_get_contents($this->sourceFile);
            if (is_array(json_decode($this->jsonString, $makeArray = true))) {
                $this->jsonArray = json_decode($this->jsonString, $makeArray = true);
            }
        }
    }

    /**
     * Create an item.
     *
     * @param $item
     *
     * @return boolean
     */
    public function create(array $item)
    {
        if (! empty($item)) {
            $arrayKeys = array_keys($item);
            if (! in_array('id', $arrayKeys)) {
                return false;
            }
            echo 'HAS ID<br>';
            if (! in_array('name', $arrayKeys)) {
                return false;
            }
            echo 'HAS NAME<br>';
            if (! in_array('dueDate', $arrayKeys)) {
                return false;
            }
            echo 'HAS DUEDATE<br>';
            array_push($this->jsonArray, $item);
            file_put_contents($this->sourceFile, json_encode(array_values($this->jsonArray)));
            $this->__construct($this->sourceFile);

            var_dump($this->jsonArray);

            return true;
        }

        return false;
    }

    /**
     * Read the array of JSON values.
     *
     * @return array
     */
    public function read()
    {
        if (is_array($this->jsonArray)) {
            return $this->jsonArray;
        }

        return array(array());
    }

    /**
     * Update an item.
     *
     * @param $id
     * @param array $attributes
     *
     * @return boolean
     */
    public function update($id, array $attributes)
    {
        //
    }

    /**
     * Delete the item from the JSON array.
     *
     * @param $id
     */
    public function delete($id)
    {
        if (is_int($id)) {
            foreach ($this->jsonArray as $key => $item) {
                if ($item['id'] === $id) {
                    unset($this->jsonArray[$key]);
                }
            }
            file_put_contents($this->sourceFile, json_encode(array_values($this->jsonArray)));
            $this->__construct($this->sourceFile);
            
            return true;
        }

        return false;
    }

    public function count()
    {
        if (is_array($this->jsonArray)) {
            return count($this->jsonArray);
        }

        return 0;
    }
}
