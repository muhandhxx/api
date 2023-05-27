<?php
include 'databasecont.php';
header("Content-Type:application/json");
$db = new DbHelper();
$db->createDbConnection();
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id = $_POST["id"];
    $db->deleteEmploye($id);
}
