<?php 
session_start(); 
$sname= "127.0.0.1";
$uname= "t66g1";
$password = "t66g1";
$db_name = "t66g1";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (!$conn) {
    echo "Connection failed!";
}
if (isset($_POST['update'])) {
    // function validate($data){
    //    $data = trim($data);
    //    $data = stripslashes($data);
    //    $data = htmlspecialchars($data);
    //    return $data;
    // }
    $recieved_id = $_POST['recieved_id1'];
    $product_id = $_POST['product_id1'];
    $date = $_POST['date1'];
    $cost_unit = $_POST['cost_unit1'];
    $qty = $_POST['qty1'];
  
  $query = "INSERT INTO recieved Values('$recieved_id'
            ,'$product_id'
            ,'$date'
            ,'$cost_unit'
            ,'$qty')"
            ;
  $result = mysqli_query($conn, $query);
  mysqli_close($conn);
  }
?>    



