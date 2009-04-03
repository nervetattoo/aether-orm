<?php

/**
 * Default Resource
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMResource {
    
    private $data = array();
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
     * Add a field to this resource
     *
     * @return void
     * @param array $field
     */
    public function addField($data) {
        
        $field = $data['field'];
        $class = 'AetherORM' . ucfirst($data['type']) . 'Field';
        $this->data[$field] = new $class($data['default'], $data['null']);
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

    
    /**
     * Save this object.
     * Used to spit out some text to see proof of concept working
     *
     * @return string $stuff
     */
    public function save() {
        $str = "\n";
        foreach ($this->data as $name => $value) {
            $str .= "$name -> " . $value->value . "\n";
        }
        return $str;
    }
    
    /**
     * "operator overload" for setters
     *
     * @return void
     * @param string $field
     * @param mixed $value
     */
    public function __set($field, $value) {
        if (isset($this->$field)) {
            if ($value instanceof AetherORMField)
                $this->data[$field] = $value;
            else
                $this->data[$field]->value = $value;
        }
    }
    
    /**
     * Overload the isset() method
     *
     * @return boolean
     * @param string $field
     */
    public function __isset($field) {
        return isset($this->data[$field]);
    }
    
    /**
     * Overload getters
     *
     * @return mixed
     * @param string $field
     */
    public function __get($field) {
        return $this->data[$field]->value;
    }
    
    /**
     * Overload the unset() method
     *
     * @return void
     * @param string $field
     */
    public function __unset($field) {
        $this->data[$field]->rem();
    }
}
class AetherORMField {
    public function __construct($value, $nullable) {
        if (empty($value) && $nullable)
            $value = null;
        $this->value = $value;
        $this->nullable = $nullable;
    }
    public function rem() {
        if ($this->nullable)
            $this->value = null;
        else
            $this->value = '';
    }
}
class AetherORMIntegerField extends AetherORMField {
}
class AetherORMStringField extends AetherORMField {
}
?>
