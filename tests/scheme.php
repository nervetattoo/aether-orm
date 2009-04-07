<?php

require_once('PHPUnit/Framework.php');
$basePath = preg_replace('/aether-orm\/tests([\/a-z]*)/', 'aether-orm/', dirname(__FILE__)); 
require_once($basePath . "AetherORM.php");

/**
 * Test that the scheme class works
 *
 * Created: 2009-04-03
 * @author Raymond Julin
 * @package aether-orm.test
 */

class TestScheme extends PHPUnit_Framework_TestCase {
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
    private $kohanaScheme = array(
        'id' => array(
            'type' => 'int',
            'max' => 2147483647,
            'unsigned' => '',
            'sequenced' => 1
        ),
        'title' => array(
            'type' => 'string',
            'length' => 64,
            'null' => 1
        )
    );

    public function testLoadFromResult() {
        $scheme = new AetherORMScheme('foo', $this->schemeResult);
        $this->assertEquals($scheme->rowCount(), 2);
    }

    public function testGetObject() {
        $scheme = new AetherORMScheme('foo', $this->schemeResult);
        $foo = $scheme->getObject();
        $this->assertTrue($foo->hasField('title'));
        $this->assertTrue($foo->getField('title') instanceof AetherORMStringField);
    }

    public function testLoadKohanaScheme() {
        $scheme = new AetherORMScheme('foo', $this->kohanaScheme);
        $foo = $scheme->getObject();
        $this->assertTrue($foo->hasField('title'));
        $this->assertTrue($foo->getField('title') instanceof AetherORMStringField);
    }
}
?>
