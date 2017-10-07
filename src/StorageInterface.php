<?php
namespace GMH;

interface StorageInterface
{
    /**
     * Create a resource to store.
     *
     * @param mixed $item
     * @return void
     */
    public function create($item);

    /**
     * Return a resource from storage.
     *
     * @param integer $id
     * @return void
     */
    public function read($id);

    /**
     * Update a stored resource.
     *
     * @param mixed $item
     * @return void
     */
    public function update($item);

    /**
     * Delete a stored resource.
     *
     * @param integer $id
     * @return void
     */
    public function delete($id);
}