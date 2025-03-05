<?php
$servername="localhost";
$username="root";
$password="";
$db_name="assessment";
$conn=new mysqli($servername,$username,$password,$db_name);//establish connection
if(!$conn){
    die("Connection failed:".$conn->connect_error);
}
else
echo "Connected to database!";
?>