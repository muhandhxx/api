<?php
include "databasecont.php";
header("Content-Type:application/json");
$db = new DbHelper();
$db->createDbConnection();
if($_SERVER["REQUEST_METHOD"]=="POST"){
     $id = $_POST["id"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $salary	 =$_POST["salary"];
    $image = $_FILES["image"];
    $db->updateEmploye($id,$name,$age,$email,$image,$salary);
}