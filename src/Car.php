<?php
namespace GMH;

require_once 'CollectionItem.php';

class Car extends CollectionItem
{
    /**
     * The model name of the car.
     *
     * @var string
     */
    protected $model;

    /**
     * The maker of the car.
     *
     * @var string
     */
    protected $manufacturer;
    
    /**
     * Sets the model name of the car.
     * Returns the object for method chaining.
     *
     * @param string $modelName
     * @return \GMH\Car
     */
    public function model($modelName) {
        $this->model = $this->validateString($modelName);
        return $this;
    }

    /**
     * Gets the model name of the car.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the manufacturer name of the car.
     * Returns the object for method chaining.
     *
     * @param string $manufacturerName
     * @return \GMH\Car
     */
    public function manufacturer($manufacturerName)
    {
        $this->manufacturer = $this->validateString($manufacturerName);
        return $this;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }
}