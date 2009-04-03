<?php

/**
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMConnection {
    private $conn;
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
