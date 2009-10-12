<?php

$db = new PDO('mysql:hostname=localhost;dbname=alice', 'root', '');

$sql  = "SELECT * FROM students";
$stmt = $db->prepare($sql);

$stmt->execute();

$rowset = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rowset as $row) {
    echo $row['name'] . "\n";
}