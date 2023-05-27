<?php
include "databasecont.php";
header("Content-Type:application/json");
$db = new DbHelper();
$db->createDbConnection();
 if($_SERVER["REQUEST_METHOD"]=="POST"){
     $name = $_POST['name'];
     $age = $_POST['age'];
     $email = $_POST['email'];
     $image = $_FILES['image'];
     $salary = $_POST['salary'];
     $db->insertNewEmpolye($name,$age,$email,$image,$salary);

 }
