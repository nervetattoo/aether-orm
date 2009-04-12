<?php

require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "AetherORM.php");

/**
 * Test entire orm
 *
 * Created: 2009-04-12
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestAetherORMIntegrates extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $basePath = preg_replace(
            '/aether-orm\/tests([\/a-z]*)/', 
            'aether-orm/', dirname(__FILE__)); 
        $this->config = $basePath . "config.php";
    }
    public function testRow() {
        AetherORM::$_config = $this->config;
        $orm = AetherORM::init();
        // Fetch a row
        $foo = $orm['d']->Foo(1);
        $this->assertEquals(1, $foo->id);
        // Use criteria based search
        $res = $orm['d']->Foo("id = 1");
        $this->assertEquals(1, $res[0]->id);
        $this->assertTrue(count($res) == 1);

        $res = $orm['d']->Foo("title = Hei");
        $this->assertEquals(1, $res[0]->id);
    }
}
?>
