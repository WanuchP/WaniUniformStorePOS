<?php
include("connection.php");

if (isset($_POST["submit"])) {
  // Assuming that you have a database connection already established with $conn
  // Get the gloGrandTotal from the POST data
 

  // Get the maxBillId
  $gloGrandTotal = $_POST["gloGrandTotal"];
  $query = "SELECT MAX(bill_id) as maxBillId FROM bill";
  $result = mysqli_query($conn, $query);

  if ($result) {
      $row = mysqli_fetch_assoc($result);
      $billId = $row['maxBillId'] + 1;
  } else {
      // Handle the error
      die("Error getting bill_id: " . mysqli_error($conn));
  }

  // Using prepared statement to prevent SQL injection
  $insertQuery = "INSERT INTO `bill` (`bill_id`, `tax`, `pickup_date`, `detail`, `total`, `customer_id`, `order_id`) VALUES ('$billId', '', '', '', '$gloGrandTotal', '', '')";
  // $stmt = $conn->prepare($insertQuery);
  $result = mysqli_query($conn, $insertQuery);
  // // Bind parameters
  // $stmt->bind_param("ii", $billId, $gloGrandTotal);
  
  // // Execute the statement
  // // $stmt->execute();
  // header("Location: 15_Billing_Summary.php");
  exit();
}

?>
