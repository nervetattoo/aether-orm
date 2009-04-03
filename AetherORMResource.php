<?php

/**
 * Resource is the blueprint of a table/row
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMResource {
    
    private $fields = array();
    private $primaryKey = '';
    
    /**
     * Constructor
     *
     * @param String $table
     */
    public function __construct($table) {
        // TODO SHould verify something here? 
        $this->table = $table;
    }
    
    /**
     * Parse some input for a field to make sure it follows any
     * general validations etc
     *
     * @return mixed
     * @param string $field
     * @param mixed $value
     */
    public function parse($field, $value) {
        $type = $this->fields[$field];
        return $type->parse($value);
    }

    /**
     * Add a field to this resource
     *
     * @return void
     * @param array $field
     */
    public function addField($data) {
        $field = $data['field'];
        $class = 'AetherORM' . ucfirst($data['type']) . 'Field';
        $this->fields[$field] = new $class($data['default'], $data['null']);
    }
    
    /**
     * Check if field exists
     *
     * @return boolean
     * @param string $name
     */
    public function hasField($name) {
        return array_key_exists($name, $this->fields);
    }
    
    /**
     * Fetch field
     *
     * @return AetherORMField
     * @param string $name
     */
    public function getField($name) {
        return $this->fields[$name];
    }
    
    /**
     * Return array over all fields
     *
     * @return array
     */
    public function getFields() {
        return array_keys($this->fields);
    }
    
    /**
     * Set primary key for this Resource
     *
     * @return void
     * @param string $key
     */
    public function setPrimaryKey($key) {
        $this->primaryKey = $key;
    }
}
?>
