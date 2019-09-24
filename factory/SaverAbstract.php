<?php

namespace app\factory;

/**
 * Manages of data save in different storages.
 *
 * @package app\factory
 */
abstract class SaverAbstract
{
    /**
     * Creates instance of storage.
     *
     * @return StorageInterface Instance of storage.
     */
    abstract protected function getStorage(): StorageInterface;

    /**
     * Array of errors.
     *
     * @var array
     */
    public $a_errors;

    /**
     * Saves data in storage.
     *
     * @param array $a_data Data for save.
     * @return bool <tt>true</tt> - if data saved successful, <tt>false</tt> - otherwise.
     */
    public function save(array $a_data): bool
    {
        $o_storage = $this->getStorage();
        $this->a_errors = $o_storage->save($a_data);
        return $this->a_errors ? false : true;
    }
}