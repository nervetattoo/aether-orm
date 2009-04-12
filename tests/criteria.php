<?php

require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "AetherORM.php");

/**
 * Test criteria parsing
 *
 * Created: 2009-04-13
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestAetherORMCriteria extends PHPUnit_Framework_TestCase {
    public function testEquals() {
        $criteria = "id = 1";
        $crits = array(
            'id = 1' => array('id','=',1, '`id` = 1'),
            'name = foo' => array('name','=','foo', "`name` = 'foo'"),
            'name ~= foo' => array('name','~=','foo', "`name` LIKE 'foo'"),
            'id > 2' => array('id','>',2, '`id` > 2'),
        );
        foreach ($crits as $criteria => $d) {
            $c = new AetherORMCriteria($criteria);
            $this->assertEquals($d[0], $c->field);
            $this->assertEquals($d[1], $c->operand);
            $this->assertEquals($d[2], $c->value);
            $this->assertEquals($d[3], $c->getSql());
        }
    }
}
?>

