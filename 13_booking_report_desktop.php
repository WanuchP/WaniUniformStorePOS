<?php 
session_start(); 
$sname= "127.0.0.1";
$uname= "t66g1";
$password = "t66g1";
$db_name = "t66g1";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
$sql = "SELECT * FROM bill JOIN customer ON bill.customer_id = customer.customer_id order by bill.pickup_date asc";
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
  header("location:13_booking_report_desktop.php");
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
    <link rel="stylesheet" href="styles_booking_report.css">

</head>
<body style="background-color:#F2F2F2;">
    <div class="user">
        <div>User: CEO</div>
    </div>
    <div class="title">Booking Report</div>
    <table style="width: 100%;" id="dataTable">
        <thead>
        <tr>
            <th style="width: 20%;">Bill ID</th>
            <th style="width: 20%;">Customer ID</th>
            <th style="width: 20%;">Customer Name</th>
            <th style="width: 20%;">Pickup date</th>
            <th style="width: 20%;">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php  
           if ($result->num_rows>0) {  
              while ($row=$result->fetch_assoc()) {?>

                  <tr>  
                  <td><?php echo $row['bill_id'] ?></td>  
                  <td><?php echo $row['customer_id'] ?></td>
                  <td><?php echo $row['name'] ?></td>
                  <td><?php echo $row['pickup_date'] ?></td>   
                <?php  if($row["status_booking"]=="Not Recieved Yet"){
                ?> 
                  <td>
                        <select onchange="status_update(this.options[this.selectedIndex].value,'<?php echo $row['bill_id'] ?>')" class="my-dropdown">  
                            <option value="Not Recieved Yet" class="my-dropdown">Not Received Yet</option>  
                            <option value="Recieved" class="my-dropdown">Received</option>  
                        </select>  
                      </td>  
                  </tr>
                <?php }
                if($row["status_booking"]=="Recieved"){  ?>  
                  <td>
                        <select class="my-dropdown" onchange="status_update(this.options[this.selectedIndex].value,'<?php echo $row['bill_id'] ?>')" >  
                        <option value="Recieved" class="my-dropdown">Received</option>                           
                        <option value="Not Recieved Yet" class="my-dropdown">Not Received Yet</option>
                        </select> 
                      </td>  
                  </tr>   
           <?php      }}  
            } ?>              
        </tbody>
    </table>

<script type="text/javascript">  
      function status_update(value,bill_id){  
           let url = "http://win.ie.eng.chula.ac.th/~tuesday_2023/T1/Finished/13_booking_report_desktop.php";  
           window.location.href= url+"?bill_id="+bill_id+"&status_booking="+value;  
      }  
 </script> 

    <div class="bottom_line">
        <button type="button" class="button1" onclick="window.location.href='10_CEO_dektop.php'">
          <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
          <div>Return</div>
        </button>
      </div>
</body>
</html>