<?php 
session_start(); 
$sname= "127.0.0.1";
$uname= "t66g1";
$password = "t66g1";
$db_name = "t66g1";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
$product_id = $_GET['product_id'];
$status=$_GET['status_order'];
  
  $query = "UPDATE inventory SET status_order =$status WHERE product_id=$product_id";
  mysqli_query($conn, $query);
  $sql = "SELECT * FROM inventory";
  $result = $conn-> query($sql);
  // header("location:9_stock_order");
?>    