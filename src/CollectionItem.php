<?php
namespace GMH;

use Exception;

abstract class CollectionItem
{
    /**
     * The id number of the item.
     *
     * @var integer
     */
    protected $id;

    /**
     * The name of the item.
     *
     * @var string
     */
    protected $name;

    /**
     * Checks that variable type is a string.
     *
     * @param string
     * @return void
     */
    protected function validateString($string)
    {
        try {
            if (! is_string($string)) {
                throw new \Exception('ERROR: Task name must be a string.'); 
            }
            return $string;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Sets the item's name.
     * Returns the object for method chaining.
     *
     * @param string $itemName
     * @return object
     */
    public function name($itemName)
    {
        $this->name = $this->validateString($itemName);
        return $this;
    }
    
    /**
     * Gets the item's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the item's id number.
     *
     * @param mixed $id
     * @return void
     */
    protected function setId($id)
    {
        $this->id = is_numeric($id)? (int)$id : null;
    }

    /**
     * Gets the item's id number.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
