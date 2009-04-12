<?php
require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "AetherORM.php");

/**
 * Test table class
 *
 * Created: 2009-04-04
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestAetherORMTable extends PHPUnit_Framework_TestCase {
    private $schemeResult = array(
        array(
            'COLUMN_NAME' => 'id',
            'DATA_TYPE' => 'int',
            'IS_NULLABLE' => 'NO',
            'COLUMN_DEFAULT' => '',
            'EXTRA' => 'auto_increment',
            'COLUMN_KEY' => 'PRI'
        ),
        array(
            'COLUMN_NAME' => 'title',
            'DATA_TYPE' => 'varchar',
            'IS_NULLABLE' => 'YES',
            'COLUMN_DEFAULT' => '',
            'EXTRA' => '',
            'COLUMN_KEY' => ''
        )
    );
    public function setUp() {
        $basePath = preg_replace(
            '/aether-orm\/tests([\/a-z]*)/', 
            'aether-orm/', dirname(__FILE__)); 
        $this->config = $basePath . "config.php";
    }
    public function testTable() {
        AetherORM::$_config = $this->config;
        $scheme = new AetherORMScheme('foo', $this->schemeResult);
        $resource = $scheme->getObject();
        $db = 'd';
        $tbl = 'foo';
        $table = new AetherORMTable($resource, $db, $tbl);
        // Forced count, fails because loaded without configinfo
        $cnt = $table->count();
        $this->assertGreaterThan(1, $cnt);
    }
}
?>
