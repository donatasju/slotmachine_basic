<?php

namespace Core;

/**
 * Class for working with database.
 */
Class FileDB {

    /**
     * @var string Path to the database file.
     */
    private $file_uri;

    /**
     * @var type Data[] Array of data.
     */
    private $data;

    public function __construct($file_uri) {
        $this->file_uri = $file_uri;
        $this->data = null;
        $this->load();
    }

    /**
     * Sets specific row in the table.
     * @param type string $table
     * @param type string $row_id
     * @param type array $row_data
     */
    public function setRow($table, $row_id, $row_data) {
        $this->data[$table][$row_id] = $row_data;
    }

    /**
     * Gets the specific row from given table.
     * @param type string $table
     * @param type string $row_id
     * @return type array
     */
    public function getRow($table, $row_id) {
        return $this->data[$table][$row_id] ?? false;
    }

    /**
     * Sets specific column in the row.
     * @param type string $table
     * @param type string $row_id
     * @param type string $column_id
     * @param type string $column_data
     */
    public function setRowColumn($table, $row_id, $column_id, $column_data) {
        $this->data[$table][$row_id][$column_id] = $column_data;
    }

    /**
     * Gets the specific column from given table and specific row.
     * @param type string $table
     * @param type string $row_id
     * @param type string $column_id
     * @return type string
     */
    public function getRowColumn($table, $row_id, $column_id) {
        return $this->data[$table][$row_id][$column_id];
    }

    /**
     * Loads data from database, function used on constructor.
     */
    public function load() {
        if (file_exists($this->file_uri)) {
            $json_data = file_get_contents($this->file_uri);
            $this->data = json_decode($json_data, true);
        } else {
            $this->data = [];
        }
    }

    /**
     * Saves the data into the database
     * @return boolean true if save was successful
     * @throws Exception when saving to database failed.
     */
    public function save() {
        $data_json = json_encode($this->data);

        if (file_put_contents($this->file_uri, $data_json)) {
            return true;
        } else {
            throw new Exception('Neisejo issaugoti i faila.');
        }
    }

    /**
     * Deletes specific row in the table.
     * @param type string $table
     * @param type string $row_id
     */
    public function deleteRow($table, $row_id) {
        unset($this->data[$table][$row_id]);
    }

    /**
     * Checks if table with given name exists.
     * @param type string $table
     * @return type boolean
     */
    public function tableExists($table) {
        return isset($this->data[$table]) ? true : false;
    }

    /**
     * Gets all rows from the given table.
     * @param type string $table
     * @return all rows or returns false if failed to return rows.
     */
    public function getRows($table) {
        if ($this->tableExists($table)) {
            return $this->data[$table];
        } else {
            return [];
        }
    }

    /**
     * Deletes all rows from given table.
     * @param type string $table
     * @return boolean
     */
    public function deleteRows($table) {
        if ($this->tableExists($table)) {
            $this->data[$table] = [];

            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes whole given table.
     * @param type string $table
     * @return boolean
     */
    public function deleteTable($table) {
        if ($this->tableExists($table)) {
            unset($this->data[$table]);
        } else {
            return false;
        }
    }

    /**
     * Functions for returning sum of table rows
     * @param $table_name
     * @return bool|int
     */
    public function getCount($table_name) {
        if ($this->tableExists($table_name)) {
            return count($this->data[$table_name]);
        } else {
            return false;
        }
    }
}