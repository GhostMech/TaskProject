<?php
/**
 * Created by PhpStorm.
 * User: garyhowardpctech@yahoo.com
 * Date: 11/20/2017
 * Time: 6:50 PM
 */

namespace GMH;

interface StorageInterface
{
    /**
     * @param array
     * @return boolean
     */
    public function create(array $itemArray);

    /**
     * @return array
     */
    public function read();

    /**
     * @param $item
     * @return boolean
     */
    public function update($itemId, array $attributes);

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id);
}
