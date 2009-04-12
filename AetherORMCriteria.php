<?php
/**
 * A criteria for selecting rows to return
 * (WHERE clause for query)
 * 
 * Created: 2009-04-13
 * @author Raymond Julin
 * @package aether-orm
 */
class AetherORMCriteria {
    public $field,$operand,$value;
    
    /**
     * Parse criteria string
     *
     * @param string $in
     */
    public function __construct($in) {
        $regex = "#^(?P<field>[a-zA-Z]*)\s*(?P<operand>[=!~><]*)\s*(?P<value>.*)$#";
        if (preg_match($regex, $in, $matches) >= 1) {
            $this->field = $matches['field'];
            $this->operand = $matches['operand'];
            $this->value = $matches['value'];
        }
    }
    
    /**
     * Return criteria as ansi sql
     *
     * @return string
     */
    public function getSql() {
        $sql = "`{$this->field}` ";
        switch ($this->operand) {
            case '=':
            case '!=':
            case '>':
            case '<':
            case '=>':
            case '=<':
                $sql .= $this->operand;
                break;
            case '~=':
                $sql .= "LIKE";
                break;
        }
        if (is_numeric($this->value))
            $sql .= " {$this->value}";
        else
            $sql .= " '{$this->value}'";
        return $sql;
    }
}
?>
