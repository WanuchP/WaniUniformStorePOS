<?php 
session_start(); 
$sname= "127.0.0.1";
$uname= "t66g1";
$password = "t66g1";
$db_name = "t66g1";
$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (isset($_POST['update'])) {
    // function validate($data){
    //    $data = trim($data);
    //    $data = stripslashes($data);
    //    $data = htmlspecialchars($data);
    //    return $data;
    // }
    $recieved_id = $_REQUEST['recieved_id1'];
    $product_id = $_REQUEST['product_id1'];
    $date = $_REQUEST['date1'];
    $cost_unit = $_REQUEST['cost_unit1'];
    $qty = $_REQUEST['qty1'];
  
  $query = "INSERT INTO recieved Values('{$recieved_id}'
            ,'{$product_id}'
            ,'{$date}'
            ,'{$cost_unit}'
            ,'{$qty}')"
            ;
  $result = mysqli_query($conn, $query);
  mysqli_close($conn);
  }
?>    



