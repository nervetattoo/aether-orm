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
}
?>
