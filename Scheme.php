<?php

$basePath = dirname(__FILE__) . "/";
require_once($basePath . 'Resource.php');

/**
 * Table scheme helper
 * Helps with transforming a scheme over to a php object
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class Scheme {
    private $table = '';
    private $rows = array();
    private $keys = array();
    private $primaryKey = '';
    private $isOk = false;
    
    /**
     * Load data through constructor
     *
     * @param string $table Name of table
     * @param array $data Scheme information
     */
    public function __construct($table, $data) {
        $this->table = $table;
        if ($this->parseScheme($data)) {
            $this->isOk = true;
        }
    }
    
    /**
     * Return number of rows for this scheme
     *
     * @return int
     */
    public function rowCount() {
        return count($this->rows);
    }
    
    /**
     * Get this scheme as an Object, what is refered to as a Model
     * in ORM domain language.
     *
     * @return Object
     */
    public function getObject() {
        if ($this->isOk === false)
            throw new Exception("Can't create object from broken scheme");
        // Create the object, ugh
        $object = new Resource($this->table);
        foreach ($this->rows as $r) {
            $object->addField($r);
        }
        $object->setPrimaryKey($this->rows[$this->primaryKey]->field);
        return $object;
    }
    
    /**
     * Parse scheme data
     *
     * @return void
     * @param array $data
     */
    private function parseScheme($data) {
        if (count($data) == 0)
            throw new Exception("No scheme data found");
        // Aight
        $expected = array('COLUMN_NAME','DATA_TYPE','IS_NULLABLE',
            'COLUMN_DEFAULT', 'EXTRA', 'COLUMN_KEY');
        $this->rows = array();
        foreach ($data as $col) {
            // Verify that we have the required data
            if (count(array_diff(array_keys($col), $expected) == 0)) {
                $row = array(
                    'field' => $col['COLUMN_NAME'],
                    'type' => $this->parseType($col['DATA_TYPE']),
                    'null' => $col['IS_NULLABLE'] == 'YES' ? true : false,
                    'default' => $col['COLUMN_DEFAULT'],
                    'key' => $col['COLUMN_KEY'] == 'PRI' ? 'primary' : ''
                );
                $this->rows[] = $row;
                if ($col['COLUMN_KEY'] == 'PRI')
                    $this->primaryKey = count($this->rows) - 1;
            }
            else {
                // Fail!
                return false;
            }
        }
        return true;
    }
    
    /**
     * Parse what type a field is
     *
     * @return string
     * @param string $type
     */
    private function parseType($type) {
        $type = strtolower($type);
        switch ($type) {
            case 'varchar':
            case 'text':
            case 'char':
                return 'string';
            case 'tinyint':
            case 'smallint':
            case 'integer':
            case 'mediumint':
            case 'bigint':
            case 'int':
                return 'integer';
            case 'double':
            case 'float':
                return 'float';
            case 'enum':
                return 'enum';
            case 'datetime':
            case 'time':
            case 'timestamp':
                return 'time';
            case 'date':
                return 'date';
            case 'year':
                return 'integer';
        }
    }
}
?>
