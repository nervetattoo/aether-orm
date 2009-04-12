<?php
/**
 * Autoload required modules and stuff
 *
 * @param string $name
 */
function __autoload($name) {
    //Derive base path from this file
    //Support including both the libs and the tests
    if (strpos($name, 'AetherORMDatabase') !== false)
        $basePath = dirname(__FILE__) . "/drivers/";
    elseif (strpos($name, 'Field') !== false)
        $basePath = dirname(__FILE__) . "/datatypes/";
    else
        $basePath = dirname(__FILE__) . "/";

    // Final path for file
    $filePath = $basePath . $name . ".php";

    // Require the file
    if (!empty($filePath))
        require_once($filePath);
}

class AetherORMException extends Exception {}
class AetherORMMissingConfigException extends AetherORMException {}
class AetherORMNotInitializedException extends AetherORMException {}

/**
 * Facade for ORM
 * Handles configuration reading aswell as keeping
 * track of all connections. Its a singleton to ensure
 * efficiency without polluting the global scope.
 * Usage:
 *<code>
 *$db = AetherORM::init($configFile);
 *$db->test->Table(1);
 *</code>
 * 
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORM implements ArrayAccess {
    
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
     * Path to configfile
     * @var string
     */
    public static $_config = false;
    
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
    public static function init($configFile=false) {
        if ($configFile == false) {
            if (AetherORM::$_config !== false)
                $configFile = AetherORM::$_config;
            else
                throw new AetherORMMissingConfigException("No config file specified");
        }
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
        throw new Exception("No such connection exists");
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
    
    /**
     * Offset exists?
     *
     * @return boolean
     * @param string $offset
     */
    public function offsetExists($offset) {
        return isset($this->connections[$name]);
    }
    
    /**
     * Get offset
     *
     * @return AetherORMConnection
     * @param string $offset
     */
    public function offsetGet($offset) {
        return $this->$offset;
    }
    
    /**
     * Setting offset is disallowed
     *
     * @return void
     * @param string $offset
     * @param mixed $val
     */
    public function offsetSet($offset,$val) {
        return false;
    }
    
    /**
     * Unset offset is disallowed
     *
     * @return void
     * @param string $offset
     */
    public function offsetUnset($offset) {
        return false;
    }
}
?>
