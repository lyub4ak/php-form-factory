<?php


namespace app\factory;


/**
 * Creates instance of MySQL storage.
 *
 * @package app\factory
 */
class MySqlSaver extends SaverAbstract
{

    /**
     * Creates instance of MySQL storage.
     *
     * @return StorageInterface Instance of MySQL storage.
     */
    protected function getStorage(): StorageInterface
    {
        return new MySqlStorage();
    }
}