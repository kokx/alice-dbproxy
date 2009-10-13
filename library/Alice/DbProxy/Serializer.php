<?php
/**
 * Alice DBProxy
 * 
 * LICENSE
 * 
 * Alice DBProxy - Database proxy for Alice
 * Copyright (C) 2009  Pieter Kokx <pieter@kokx.nl>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 * 
 * @author   Pieter Kokx <pieter@kokx.nl>
 * @category Alice
 * @license  http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt GPL version 2
 * @package  Alice_DBProxy
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