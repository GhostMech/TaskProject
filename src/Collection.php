<?php
namespace GMH;

abstract class Collection
{
    /**
     * The storage interface.
     *
     * @var \GMH\StorageInterface
     */
    private $storage;

    /**
     * The collection of items.
     *
     * @var array
     */
    private $items = [];

    /**
     * Constructs the storage interface.
     *
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Gets the first item in the collection.
     *
     * @return mixed
     */
    public function first()
    {
        return array_values($this->items)[0];
    }

    /**
     * Gets the last item in the collection.
     *
     * @return mixed
     */
    public function last()
    {
        $values = array_values($this->items);
        return array_pop($values);
    }

    /**
     * Gets all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
}
