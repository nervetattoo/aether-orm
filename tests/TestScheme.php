<?php

require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "Scheme.php");
require_once($basePath . "drivers/Database.php");
require_once($basePath . "drivers/Database/Mysql.php");

/**
 * Test that the scheme class works
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestScheme extends PHPUnit_Framework_TestCase {
    private $config = array(
        'connection' => array(
            'host' => 'localhost',
            'port' => 3306,
            'user' => 'root',
            'pass' => 'root',
            'database' => 'foo'
        )
    );
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

    public function testLoadFromResult() {
        $scheme = new Scheme('foo', $this->schemeResult);
        $this->assertEquals($scheme->rowCount(), 2);
    }

    public function testGetObject() {
        $scheme = new Scheme('foo', $this->schemeResult);
        $foo = $scheme->getObject();
        $foo->title = 'Hello';
        $tmp = $foo->save();
        echo $tmp;
    }
}
?>
