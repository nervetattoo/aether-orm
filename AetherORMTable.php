<?php

/**
 * Table
 *
 * Created: 2009-04-04
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMTable {
    private $_resource = null;
    private $_database = '';
    private $_table = '';
    private $_orm = null;
    private $_conn = null;
    
    /**
     * Construct row
     *
     * @param AetherORMResource $resource
     *   This is the blueprint of the tables details.
     *   In other words the Resource knows what fields this Table should
     *   support.
     * @param string $database What database identifier to use
     * @param string $table Name of table
     */
    public function __construct(AetherORMResource $resource, $database, $table) {
        $this->_resource = $resource;
        $this->_database = $database;
        $this->_table = $table;
    }
    
    /**
     * Fetch database instance
     *
     * @return boolean
     */
    private function getDb() {
        if ($this->_orm === null) {
            try {
                $this->_orm = AetherORM::init();
                $this->_db = $this->_orm->{$this->_database}->getDriver();
            }
            catch (AetherORMMissingConfigException $e) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Count number of rows in table
     *
     * @access public
     * @return int
     */
    public function count() {
        if (!$this->getDb()) {
            throw new AetherORMNotInitializedException(
                "AetherORM is not correctly initialized");
            return 0;
        }
        $sql = "SELECT COUNT(*) AS cnt FROM {$this->_table}";
        $result = $this->_db->query($sql)->as_array();
        return (int) $result[0]['cnt'];
    }
}
?>
