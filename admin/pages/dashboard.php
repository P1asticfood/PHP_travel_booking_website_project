<!--  --><?php
$host='localhost';
$username='root';
$password='';
$db_name='travelbookingwebsite';
$conn = new mysqli($host,$username,$password,$db_name);
if(!$conn){
    die("Connection failed: " . $conn->connect_error);
}
?>