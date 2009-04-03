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

class TestAetherORMRow extends PHPUnit_Framework_TestCase {
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
    public function testSettersAndGetters() {
        $scheme = new AetherORMScheme('foo', $this->schemeResult);
        $resource = $scheme->getObject();
        $row = new AetherORMRow($resource);
        $row->title = 'foo';
        var_dump($row);
    }
}
?>

