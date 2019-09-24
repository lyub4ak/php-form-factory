<?php

namespace app\factory;

/**
 * Storage for data save.
 *
 * @package app\factory
 */
interface StorageInterface
{
    /**
     * Saves data.
     *
     * @param array $a_data Data for save.
     * @return array Array of errors.
     */
    public function save(array $a_data): array;
}
