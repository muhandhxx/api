<?php
include "databasecont.php";
header("Content-Type:application/json");
$db = new DbHelper();
$db->createDbConnection();
if($_SERVER["REQUEST_METHOD"]=="GET"){
    if(isset($_GET["id"])){
        $db->getEmployeById($_GET["id"]);
    }else{
        $db->getAllEmpoyles();
    }
}