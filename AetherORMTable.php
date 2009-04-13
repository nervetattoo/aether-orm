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
            catch (Exception $e) {
                throw $e;
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
    
    /**
     * Return row by id (primary key)
     *
     * @return AetherORMRow
     * @param int $key
     */
    public function byId($key) {
        if (!$this->getDb()) {
            throw new AetherORMNotInitializedException(
                "AetherORM is not correctly initialized");
            return 0;
        }
        $sql = "SELECT * FROM {$this->_table} WHERE id = $key LIMIT 1";
        $result = $this->_db->query($sql)->as_array();
        $data = array();
        foreach ($result[0] as $name => $value)
            $data[$name] = $value;
        return new AetherORMRow($this->_resource, $data);
    }

    /**
     * Return a set of rows from sql
     *
     * @return array
     * @param int $key
     */
    public function bySql($sql) {
        if (!$this->getDb()) {
            throw new AetherORMNotInitializedException(
                "AetherORM is not correctly initialized");
            return 0;
        }
        $results = $this->_db->query($sql)->as_array();
        $rows = new AetherORMSet;
        foreach ($results as $res) {
            $data = array();
            foreach ($res as $name => $value)
                $data[$name] = $value;
            $rows[] = new AetherORMRow($this->_resource, $data);
        }
        return $rows;
    }
}
?>
