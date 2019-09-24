<?php


namespace app\factory;


/**
 * Saves data in file.
 *
 * @package app\factory
 */
class FileStorage implements StorageInterface
{
    /**
     * Saves data in file.
     *
     * @param array $a_data Data for save.
     * @return array Array of errors.
     */
    public function save(array $a_data): array
    {
        $a_error = [];
        $s_file_path = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'contact.txt';

        // Prepares text for save in file.
        $text_contact = PHP_EOL.PHP_EOL.'Name: '.$a_data['name'];
        $text_contact .= PHP_EOL.'Phone: '.$a_data['phone'];
        $text_contact .= PHP_EOL.'Message: '.$a_data['message'];
        $text_contact .= PHP_EOL.'Date create: '.date('Y-m-d H:i:s');

        // Saves data in file.
        $x_file = fopen($s_file_path, 'a');
        if(!fwrite($x_file, $text_contact))
            $a_error[] = 'Ошибка записи в файл.';
        fclose($x_file);

        return $a_error;
    }
}