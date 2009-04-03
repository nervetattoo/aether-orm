<?php

$basePath = dirname(__FILE__) . "/";
require_once($basePath . "drivers/Database.php");
require_once($basePath . "drivers/Database/Mysql.php");
require_once($basePath . 'Resource.php');
require_once($basePath . 'Scheme.php');
require_once($basePath . 'AetherORMConnection.php');

/**
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORM {
    
    /**
     * Connections
     * @var array
     */
    private $connections = array();
    
    /**
     * Hold singleton
     * @var AetherORM
     */
    private static $_self = null;
    
    /**
     * Constructor, accepts path to config file
     *
     * @param string $configFile
     */
    private function __construct($configFile) {
        $this->initializeConfiguration($configFile);
    }
    
    /**
     * Init method as this is a singleton
     *
     * @return AetherORM
     * @param string $configFile
     */
    public static function init($configFile) {
        if (self::$_self == null)
            self::$_self = new AetherORM($configFile);
        return self::$_self;
    }
    
    /**
     * Initialize configuration found in file
     *
     * @return void
     * @param string $file
     */
    public function initializeConfiguration($file) {
        if (file_exists($file)) {
            include($file);
            foreach ($aetherOrmConfig as $name => $config) {
                $this->connections[$name] = new AetherORMConnection($config);
            }
        }
        else {
            // TODO Throw exception
        }
    }
    
    /**
     * Get a connection (all ->$foo references on this objects
     * represents a database connection ready to be used
     *
     * @return AetherORMConnection
     * @param string $name
     */
    public function __get($name) {
        if (isset($this->connections[$name]))
            return $this->connections[$name];
        // TODO Throw exception
    }
    
    /**
     * Using setters on this object is strictly prohibited
     *
     * @return void
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value) {
        // TODO Correct exception type
        throw new Exception(
            "Illegal operation, trying to set AetherORM::$name = $value");
    }
}
?>
