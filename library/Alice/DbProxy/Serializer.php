<?php
/**
 * Alice DBproxy
 * 
 * @author Pieter Kokx <pieter@kokx.nl>
 * @category Alice
 * @package Alice_DbProxy
 */

namespace Alice\DbProxy;
use PDO, PDOStatement;

/**
 * Serializer for the DB proxy
 * 
 * @author Pieter Kokx <pieter@kokx.nl>
 * @category Alice
 * @package Alice_DbProxy
 */
class Serializer
{
    
    /**
     * Statement
     * 
     * @var PDOStatement
     */
    protected $_stmt;
    
    /**
     * Placeholder
     * 
     * @var string
     */
    protected $_separator = "\0";
    
    
    /**
     * Constructor
     * 
     * @param PDOStatement $stmt
     * @param string $separator
     * 
     * @return void
     */
    public function __construct(PDOStatement $stmt, $separator = "\0")
    {
        $this->_separator = $separator;
        $this->_stmt      = $stmt;
    }
    
    public function serialize()
    {
        $this->_stmt->execute();
        
        $data = $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($data)) {
            return '';
        }
        
        $return = implode($this->_separator, array_keys($data[0]));
        
        foreach ($data as $row) {
            $return .= "\n" . implode($this->_separator, $row);
        }
        
        return $return;
    }
}