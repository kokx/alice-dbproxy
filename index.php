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

// read the config file 
$config = require 'config.php';

// configure include path

$path = array(
    dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library',
    '.'
);
set_include_path(implode(PATH_SEPARATOR, $path));

// the autoloader

function autoload($name)
{
    require_once str_replace("\\", '/', $name) . ".php";
}

spl_autoload_register('autoload');

//$serializer = new Alice\DbProxy\Serializer();

$db = new PDO($config['db']['dsn'], $config['db']['username'], $config['db']['password']);

// just a normal statement
if (isset($_REQUEST['query'])) {
    $stmt = $db->prepare($_REQUEST['query']);
    
    $serializer = new Alice\DbProxy\Serializer($stmt);
    
    $serializer->parseParams();
    
    if (isset($_REQUEST['serialize'])) {
        echo $serializer->serialize();
    } else {
        echo $serializer->dump();
    }
}