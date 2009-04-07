<?php

require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "AetherORM.php");

/**
 * Test Row
 *
 * Created: 2009-04-04
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestAetherORMConnection extends PHPUnit_Framework_TestCase {
    private $config = array(
        'type' => 'mysql',
        'host' => 'localhost',
        'port' => 3306,
        'user' => 'root',
        'pass' => 'root',
        'database' => 'foo'
    );
    public function testLoadById() {
        $con = new AetherORMConnection($this->config);
        $tbl = $con->Foo();
        $this->assertTrue($tbl instanceof AetherORMTable);
    }
}
?>
