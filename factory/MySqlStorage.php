<?php

namespace app\factory;

use PDO;
use PDOException;

/**
 *Saves data in MySQL database.
 *
 * @package app\factory
 */
class MySqlStorage implements StorageInterface
{
    /**
     * Saves data in MySQL database.
     *
     * @param array $a_data Array of data for save in database.
     * @return array Array of errors if errors are.
     */
    public function save(array $a_data): array
    {
        $text_servername = "php-form-factory.local";
        $text_database = "php-form-factory";
        $text_username = "root";
        $text_password = "";
        $text_sql = "mysql:host=$text_servername;dbname=$text_database;";
        $a_dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $a_errors = [];

        // Creates a new connection to the MySQL database using PDO, $o_db_connection is an object
        try {
            $o_db_connection = new PDO($text_sql, $text_username, $text_password, $a_dsn_Options);
            // Connected successfully.
        } catch (PDOException $error) {
            $a_errors[] = 'Connection error: ' . $error->getMessage();
            return $a_errors;
        }

        // Prepares SQL query.
        $o_query = $o_db_connection->prepare("
        INSERT INTO 
            contact (text_name, text_phone, text_message, dtu_create)
        VALUES
            (:text_name, :text_phone, :text_message, NOW())
    ");
        // Binds data to query.
        $o_query->bindParam(':text_name', $a_data['name']);
        // All emails will be saved in database in lower chars.
        $o_query->bindParam(':text_phone', $a_data['phone']);
        $o_query->bindParam(':text_message', $a_data['message']);

        // Executes the query using the data we just defined.
        if (!$o_query->execute())
            $a_errors[] = "Unable to create record.";

        return $a_errors;
    }
}