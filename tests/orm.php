<?php

require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "AetherORM.php");

/**
 * Test that AetherORM works
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestAetherORM extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
        $this->config = $basePath . "config.php";
    }
    public function testConfigLoads() {
        // INclude config, makes $aetherOrmConfig avail
        include($this->config);
        $db = AetherORM::init($this->config);
        $this->assertEquals($db->d->whichDatabase(), $aetherOrmConfig['d']['database']);
    }
    
    public function testSetterCrashes() {
        $db = AetherORM::init($this->config);
        $isOk = false;
        try {
            $db->foo = 'bar';
        }
        catch (Exception $e) {
            $isOk = true;
        }
        $this->assertTrue($isOk);
    }
}
?>
