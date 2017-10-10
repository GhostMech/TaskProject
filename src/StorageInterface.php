<?php
namespace GMH;

interface StorageInterface
{
    /**
     * Create a resource to store.
     *
     * @param mixed $item
     * @return boolean
     */
    public function create($item);

    /**
     * Return a resource from storage.
     *
     * @param integer $id
     * @return mixed
     */
    public function read($id);

    /**
     * Update a stored resource.
     *
     * @param mixed $item
     * @return boolean
     */
    public function update($item);

    /**
     * Delete a stored resource.
     *
     * @param integer $id
     * @return boolean
     */
    public function delete($id);
}