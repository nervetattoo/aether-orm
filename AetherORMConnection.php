<?php
/**
 * Holds a connection to a database (as set in configuration file)
 * This selects the correct database driver and initializes it and
 * lets you run queries through it
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMConnection {
    
    /**
     * Connection object
     * @var AetherORMDatabaseDriver
     */
    private $conn;
    
    /**
     * Configuration that this connection was built from
     * @var array
     */
    private $config;
    
    /**
     * Create connection
     *
     * @param array $config
     */
    public function __construct($config) {
        switch ($config['type']) {
            case 'mysql':
            default:
                $driver = 'Mysql';
                break;
        }
        $class = 'AetherORMDatabase' . $driver . 'Driver';
        $this->conn = new $class(array('connection'=>$config));
        if ($this->conn->connect() === false) {
            throw new Exception(
                "Connecting to database [{$config['database']}] failed");
        }
        $this->config = $config;
    }
    
    /**
     * Determine which database we are connected to
     *
     * @return string
     */
    public function whichDatabase() {
        return $this->config['database'];
    }
    
    /**
     * Willy wonkas magic little factory.
     * Every method called unto Connection goes here for parsing
     * and its then delegated on to a table
     *
     * @return AetherORMTable
     * @param string $name
     * @param array $args
     */
    public function __call($func, $args) {
        $table = strtolower($func);
        $db = $this->config['database'];
        /**
         * Get scheme
         */

        if (count($args) == 0) {
            // No args means get the whole table object
            // TODO Resource creation needs fix
            $resource = new AetherORMResource($table,array());
            $result = new AetherORMTable($resource, $db, $table);
        }
        elseif (count($args) == 1 AND is_numeric($args[0])) {
            /**
             * Special case for only one integer arg.
             * This means we want to select by primary key
             */
            $primaryKey = $args[0];
            /**
             * TODO
             * 1. Ask IM if Row object exists
             * 2. Ask identity map for scheme for table
             * 3. Load scheme (here or IM?)
             * 4. Load Row based on scheme
             */
        }
        else {
            // TODO Magic!
        }
        return $result;
    }
    
    /**
     * Get the actual driver
     *
     * @access public
     * @return AetherORMDatabaseDriver
     */
    public function getDriver() {
        return $this->conn;
    }
}
?>
