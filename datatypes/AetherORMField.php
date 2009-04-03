<?php

/**
 * Base class for "fields" (Data types)
 *
 * Created: 2009-04-04
 * @author Raymond Julin
 * @package aether-orm
 */

abstract class AetherORMField {
    
    /**
     * Constructor
     * Accepts value and wether or not field is nullable in 
     * its used context
     *
     * @param mixed $value
     * @param boolean $nullable
     */
    public function __construct($nullable) {
        $this->nullable = $nullable;
    }
    
    /**
     * Parse incoming data according to this data type
     * TODO Make abstract and move out
     *
     * @return mixed
     * @param mixed $data
     */
    public function parse($data) {
        if (empty($data) AND $this->nullable)
            return null;
        else
            return $data;
    }
}
?>
