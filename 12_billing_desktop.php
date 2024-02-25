<?php 
session_start(); 
$sname= "127.0.0.1";
$uname= "t66g1";
$password = "t66g1";
$db_name = "t66g1";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
$sql = "SELECT b.pickup_date as pickup_date, b.bill_id as bill_id, b.total as total, b.customer_id as customer_id , c.name as customer_name
        FROM bill b, customer c 
        WHERE b.customer_id = c.customer_id
        order by bill_id desc";
$result = $conn-> query($sql);
if (isset($_GET['bill_id'])&&isset($_GET['status_booking'])) {
  $bill_id = $_GET['bill_id'];
  $status_booking = $_GET['status_booking'];

  // Prepared statement to prevent SQL injection
  $query = "UPDATE bill SET status_booking = ? WHERE bill_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("si", $status_booking, $bill_id);
  $stmt->execute();

  // Redirect back to the page after the update
  header("location:12_billing_desktop.php");
  exit();
  }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inria+Sans&display=swap');
      </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing desktop</title>
    <link rel="stylesheet" href="styles_bill_desk.css">
  

</head>
<body style="background-color:#F2F2F2;">
    <div class="user">
        <div>User: CEO</div>
    </div>
    <div class="title">Billing desktop</div>

    <table style="width: 100%;" id="dataTable">
        <thead>
        <tr>
            <th style="width: 20%;">Date</th>
            <th style="width: 20%;">Bill ID</th>
            <th style="width: 20%;">Customer ID</th>
            <th style="width: 20%;">Customer Name</th>
            <th style="width: 20%;">Grand-total</th>
        </tr>
        </thead>
        <tbody>
        <?php  
          if ($result->num_rows>0) {  
            while ($row=$result->fetch_assoc()) {?>

            <tr>  
              <td><?php echo $row['pickup_date'] ?></td>  
              <td><?php echo $row['bill_id'] ?></td>
              <td><?php echo $row['customer_id'] ?></td>
              <td><?php echo $row['customer_name'] ?></td>
              <td><?php echo $row['total'] ?></td>   
            </tr>
            <?php }} ?>
            
            
        </tbody>
    </table>
    <div class="bottom_line">
        <button type="button" class="button1" onclick="window.location.href='10_CEO_dektop.php'">
          <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
          <div>Return</div>
        </button>
      </div>
</body>
</html>