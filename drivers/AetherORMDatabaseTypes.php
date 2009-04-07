<?php

/**
 * Field types in databases
 * Originaly from Kohana Framework
 *
 * Created: 2009-04-07
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMDatabaseTypes {
    
    /**
     * Return array over data types
     *
     * @return array
     */
    public static function get() {
        $types = array(
            'tinyint' => array('type' => 'int', 'max' => 127),
            'smallint' => array('type' => 'int', 'max' => 32767),
            'mediumint' => array('type' => 'int', 'max' => 8388607),
            'int' => array('type' => 'int', 'max' => 2147483647),
            'integer' => array('type' => 'int', 'max' => 2147483647),
            'bigint' => array('type' => 'int', 'max' => 9223372036854775807),
            'float' => array('type' => 'float'),
            'float unsigned' => array('type' => 'float', 'min' => 0),
            'boolean' => array('type' => 'boolean'),
            'time' => array('type' => 'string', 'format' => '00:00:00'),
            'time with time zone' => array('type' => 'string'),
            'date' => array('type' => 'string', 'format' => '0000-00-00'),
            'year' => array('type' => 'string', 'format' => '0000'),
            'datetime' => array('type' => 'string', 'format' => '0000-00-00 00:00:00'),
            'timestamp with time zone' => array('type' => 'string'),
            'char' => array('type' => 'string', 'exact' => TRUE),
            'binary' => array('type' => 'string', 'binary' => TRUE, 'exact' => TRUE),
            'varchar' => array('type' => 'string'),
            'varbinary' => array('type' => 'string', 'binary' => TRUE),
            'blob' => array('type' => 'string', 'binary' => TRUE),
            'text' => array('type' => 'string')
        );
        // DOUBLE
        $types['double'] = $types['double unsigned'] = $types['decimal'] = 
            $types['real'] = $types['numeric'] = $types['float'];
        // BIT
        $types['bit'] = $types['boolean'];
        // TIMESTAMP
        $types['timestamp'] = $types['timestamp without time zone'] = 
            $types['datetime'];
        // ENUM
        $types['enum'] = $types['set'] = $types['varchar'];
        // TEXT
        $types['tinytext'] = $types['mediumtext'] = 
            $types['longtext'] = $types['text'];
        // BLOB
        $types['tinyblob'] = $types['mediumblob'] = $types['longblob'] = 
            $types['clob'] = $types['bytea'] = $types['blob'];
        // CHARACTER
        $types['character'] = $types['char'];
        $types['character varying'] = $types['varchar'];
        // TIME
        $types['time without time zone'] = $types['time'];
        return $types;
    }
}
?>
