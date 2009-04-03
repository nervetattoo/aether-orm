<?php

/**
 * Base class for "fields" (Data types)
 *
 * Created: 2009-04-04
 * @author Raymond Julin
 * @package aether-orm
 */

class AetherORMField {
    
    /**
     * Constructor
     * Accepts value and wether or not field is nullable in 
     * its used context
     *
     * @param mixed $value
     * @param boolean $nullable
     */
    public function __construct($value, $nullable) {
        if (empty($value) && $nullable)
            $value = null;
        $this->value = $value;
        $this->nullable = $nullable;
    }
    
    /**
     * Reset the contextly held value
     *
     * @return void
     */
    public function rem() {
        if ($this->nullable)
            $this->value = null;
        else
            $this->value = '';
    }
}
?>
