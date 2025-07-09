<?php
$host='localhost';
$username='root';
$passsword='';
$db_name='travelbookingwebsite';
$conn= new mysqli($host,$username,$passsword,$db_name);
if(!$conn){
    die("connection failed: ".$conn->connect_error);
}
?>