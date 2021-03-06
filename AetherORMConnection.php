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
     * Stash of schemes/resources?
     * TODO move to identity map
     * @var array
     */
    private $schemes = array();
    
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
        $tableName = strtolower($func);
        $name = $this->config['name'];
        /**
         * Get scheme
         */
        if (!array_key_exists($tableName, $this->schemes)) {
            $schemeData = $this->conn->list_fields($tableName);
            $this->schemes[$tableName] = 
                new AetherORMScheme($tableName, $schemeData);

        }
        // TODO Resource creation needs fix. Load data!
        $resource = $this->schemes[$tableName]->getObject();
        //$resource = new AetherORMResource($tableName,array());
        $table = new AetherORMTable($resource, $name, $tableName);

        if (count($args) == 0) {
            // No args means get the whole table object
            $result = $table;
        }
        elseif (count($args) == 1 AND is_numeric($args[0])) {
            /**
             * Special case for only one integer arg.
             * This means we want to select by primary key
             */
            $primaryKey = $args[0];
            $result = $table->byId($primaryKey);
            /**
             * TODO
             * 1. Ask IM if Row object exists
             * 2. Ask identity map for scheme for table
             * 3. Load scheme (here or IM?)
             * 4. Load Row based on scheme
             */
        }
        else {
            /**
             * Regular criteria based search.
             * "Criteria" includes everything not being a full table
             * fetch or a single row fetch by primary key
             */
            $criterias = array();
            $where = "WHERE ";
            foreach ($args as $argument) {
                $c = new AetherORMCriteria($argument);
                $where .= $c->getSql() . " AND";
                $criterias[] = $c;
            }
            // Remove the last AND
            $where = substr($where, 0, -4);
            /**
             * TODO THis should go through a query builder, not as
             * directly typed SQL
             * TODO Support for OR-based WHERE clauses?
             */
            $result = $table->bySql("SELECT * FROM $tableName $where");
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
