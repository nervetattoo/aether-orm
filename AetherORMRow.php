<?php

/**
 * Row
 *
 * Created: 2009-04-04
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMRow {

    private $_data = array();
    private $_changed = array();
    private $_resource = null;
    
    /**
     * Construct row
     *
     * @param AetherORMResource $resource
     *   This is the blueprint of the rows details (or tables if you like).
     *   In other words the Resource knows what fields this Row/Model should
     *   support.
     * @param array $data
     *   Optional, this can contain the data for this row if its an existing
     *   Row being loaded
     */
    public function __construct(AetherORMResource $resource, $data=array()) {
        $this->_resource = $resource;
        /**
         * getFields() returns all table scheme fields (id, title and such)
         * _data needs to have these fields set to an empty value
         * (unless $data provided) so __set() will work later on
         * This is how doing $row->nonExistantField = 'foo' is disabled
         */
        foreach ($resource->getFields() as $key) {
            $this->_data[$key] = '';
            if (isset($data[$key]))
                $this->$key = $data[$key];
        }
    }

    /**
     * Called when $row->field = 'value'; assignment happens
     *
     * @return void
     * @param string $field
     * @param mixed $value
     */
    public function __set($field, $value) {
        /**
         * This uses Resource (scheme) to parse the input.
         * parse() can for example ensure that NULL restrictions
         * are looked after
         */
        if (isset($this->_data[$field])) {
            $this->_data[$field] = $this->_resource->parse($field,$value);
            $this->_changed[] = $field;
            $this->_changed = array_unique($this->_changed);
        }
    }
    
    /**
     * Overload the isset() method
     *
     * @return boolean
     * @param string $field
     */
    public function __isset($field) {
        return isset($this->_data[$field]);
    }
    
    /**
     * Called when $foo = $row->field; is called
     *
     * @return mixed
     * @param string $field
     */
    public function __get($field) {
        return $this->_data[$field];
    }
    
    /**
     * Overload the unset() method
     *
     * @return void
     * @param string $field
     */
    public function __unset($field) {
        unset($this->_data[$field]);
    }
    
    /**
     * Save this object.
     * Used to spit out some text to see proof of concept working
     *
     * @return string $stuff
     */
    public function save() {
        if (count($this->_changed) > 0) {
            $table = $this->_resource->getTable();
            $data = array();
            foreach ($this->_changed as $field)
                $data[$field] = $this->_data[$field];
        }
    }
}
?>
