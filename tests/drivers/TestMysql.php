<?php

require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "drivers/Database.php");
require_once($basePath . "drivers/Database/Mysql.php");

/**
 * Test that mysql adapter works
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestMysql extends PHPUnit_Framework_TestCase {
    private $config = array(
        'connection' => array(
            'host' => 'localhost',
            'port' => 3306,
            'user' => 'root',
            'pass' => 'root',
            'database' => 'foo'
        )
    );

    public function testConnect() {
        $db = new AetherDatabaseMysqlDriver($this->config);
        $this->assertTrue($db->connect() !== false);
    }

    public function testQuery() {
        $db = new AetherDatabaseMysqlDriver($this->config);
        $db->connect();
        $sql = "SELECT * FROM foo LIMIT 2";
        $res = $db->query($sql);
        $this->assertTrue(is_array($res->as_array(true)));
        $this->assertTrue(count($res->as_array(true)) == 2);
    }
}
?>
