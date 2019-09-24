<?php

namespace app\factory;

/**
 * Creates instance of file storage.
 *
 * @package app\factory
 */
class FileSaver extends SaverAbstract
{

    /**
     * Creates instance of file storage.
     *
     * @return StorageInterface Instance of file storage.
     */
    protected function getStorage(): StorageInterface
    {
        return new FileStorage();
    }
}