<?php
/**
 * Alice DBproxy
 * 
 * @author Pieter Kokx <pieter@kokx.nl>
 * @category Alice
 * @package Alice_DBProxy
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
    $stmt = $db->prepare($_GET['query']);
    
    if (isset($_REQUEST['serialize'])) {
        $serializer = new Alice\DbProxy\Serializer($stmt);
        
        echo $serializer->serialize();
    } else {
        $stmt->execute();
        
        var_dump($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}