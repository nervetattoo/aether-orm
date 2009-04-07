<?php
/**
 * Table scheme helper
 * Helps with transforming a scheme over to a php object
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMScheme {
    
    /**
     * Table used
     * @var string
     */
    private $table = '';
    
    /**
     * Hold fields in table
     * @var array
     */
    private $fields = array();
    
    /**
     * Keys
     * @var array
     */
    private $keys = array();
    
    /**
     * Primary key. Index to $fields array
     * @var int
     */
    private $primaryKey = '';
    
    /**
     * Whether parsed scheme is ok
     * @var boolean
     */
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
            // Scheme was parsed succesfully
            $this->isOk = true;
        }
    }
    
    /**
     * Return number of fields for this scheme
     *
     * @return int
     */
    public function rowCount() {
        return count($this->fields);
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
        // Create a Resource
        $object = new AetherORMResource($this->table);
        foreach ($this->fields as $r) {
            $object->addField($r);
        }
        $object->setPrimaryKey($this->fields[$this->primaryKey]->field);
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
        /**
         * This is the keys we expect to find in the scheme information
         */
        $expected = array('COLUMN_NAME','DATA_TYPE','IS_NULLABLE',
            'COLUMN_DEFAULT', 'EXTRA', 'COLUMN_KEY');
        $this->fields = array();
        foreach ($data as $key => $col) {
            if (is_string($key)) {
                $this->fields[] = array(
                    'field' => $key,
                    'type' => $this->parseType($col['type']),
                    'null' => $col['null'] == 1 ? true : false
                );
            }
            elseif (count(array_diff(array_keys($col), $expected) == 0)) {
                /**
                 * Scheme information from sql is to verbose,
                 * compact it for easier code later on
                 */
                $this->fields[] = array(
                    'field' => $col['COLUMN_NAME'],
                    'type' => $this->parseType($col['DATA_TYPE']),
                    'null' => $col['IS_NULLABLE'] == 'YES' ? true : false,
                    'default' => $col['COLUMN_DEFAULT'],
                    'key' => $col['COLUMN_KEY'] == 'PRI' ? 'primary' : ''
                );
                /**
                 * Track index of primary key field
                 * TODO Composite primary key will fail yes?
                 */
                if ($col['COLUMN_KEY'] == 'PRI')
                    $this->primaryKey = count($this->fields) - 1;
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
     * TODO This feelds bad
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
            case 'string':
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
