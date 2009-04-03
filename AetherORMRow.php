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
    private $_resource = null;
    
    /**
     * Construct row
     *
     * @param AetherORMResource $resource
     * @param array $data
     */
    public function __construct(AetherORMResource $resource, $data=array()) {
        // Initialize internal data array from $resource
        $this->_resource = $resource;
        foreach ($resource->getFields() as $key)
            $this->_data[$key] = '';
    }

    /**
     * "operator overload" for setters
     *
     * @return void
     * @param string $field
     * @param mixed $value
     */
    public function __set($field, $value) {
        if (isset($this->_data[$field]))
            $this->_data[$field] = $this->_resource->parse($field,$value);
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
     * Overload getters
     *
     * @return mixed
     * @param string $field
     */
    public function __get($field) {
        return $this->_data[$field]->value;
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
        $str = "\n";
        foreach ($this->_data as $name => $value) {
            $str .= "$name -> " . $value . "\n";
        }
        return $str;
    }
}
?>
