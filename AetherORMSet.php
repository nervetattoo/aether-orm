<?php

/**
 * A set of Rows
 *
 * Created: 2009-04-13
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMSet implements ArrayAccess, Countable {
    
    /**
     * Hold set objects
     * @var array
     */
    private $data = array();
    
    /**
     * Count
     *
     * @return int
     */
    public function count() {
        return count($this->data);
    }
    
    /**
     * Offset exists?
     *
     * @return boolean
     * @param string $offset
     */
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }
    
    /**
     * Get offset
     *
     * @return AetherORMConnection
     * @param string $offset
     */
    public function offsetGet($offset) {
        return $this->data[$offset];
    }
    
    /**
     * Setting offset is disallowed
     *
     * @return void
     * @param string $offset
     * @param mixed $val
     */
    public function offsetSet($offset,$val) {
        if ($offset == null)
            $offset = count($this->data);
        $this->data[$offset] = $val;
    }
    
    /**
     * Unset offset is disallowed
     *
     * @return void
     * @param string $offset
     */
    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
}
?>
