<?php 
session_start(); 
$sname= "127.0.0.1";
$uname= "t66g1";
$password = "t66g1";
$db_name = "t66g1";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
$sql = "SELECT * FROM inventory";
$result = $conn-> query($sql);




if (isset($_GET['product_id'])&&isset($_GET['status_order'])) {
  //   $product_id = $_GET['product_id'];
  //   $status=$_GET['status_order'];
  
  // $query = "UPDATE inventory SET status_order =$status where product_id=$product_id";
  // mysqli_query($conn, $query);
  // $result = $conn-> query($sql);
  // header("location:9_stock_order.php");
  // die();
  $product_id = $_GET['product_id'];
  $status = $_GET['status_order'];

  // Prepared statement to prevent SQL injection
  $query = "UPDATE inventory SET status_order = ? WHERE product_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("si", $status, $product_id);
  $stmt->execute();

  // Redirect back to the page after the update
  header("location: 9_stock_order.php");
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
    <link rel="stylesheet" href="styles_stock_order.css">
    <script src="./jquery-3.7.1.min.js"></script>
  <!-- <script type = "text/javascript">
    $(document).ready(function(){
      // function updateData() {
        $("#update-container").load("./stock_order_update.php")
        setInterval(function() {
            $.ajax({
              url: './stock_order_show.php',
              success: function (data) {
                  $('#update-container').load("./stock_order_show.php");
              }
          });
        }, 5);
      // }
    });
</script> -->

</head>
<body style="background-color:#F2F2F2;">
    <div class="user">
        <div>User: Stock1</div>
    </div>
    <div class="title">Order to Supplier</div>

    <table style="width: 100%;" id="dataTable">
        <thead>
        <tr>
            <th style="width: 20%;">Product_ID</th>
            <th style="width: 20%;">InStock_Quantity</th>
            <th style="width: 20%;">Reorder_Point</th>
            <th style="width: 20%;">Lead_Time</th>
            <th style="width: 20%;">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //include('connection.php');
        $sql = "SELECT * FROM inventory";
        $result = $conn-> query($sql);
           if ($result->num_rows>0) {  
            $n=0;
              while ($row=$result->fetch_assoc()) { 
                $n++;
                if($row["instock_qty"]>$row["reorder_point"]){
                  //$word = "No Need To Order";
                  $query1 = "UPDATE inventory SET status_order = 'No Need To Order' WHERE product_id = $n";
                  $result1 = $conn-> query($query1);
                }
              }
              $n=0;
              $sql = "SELECT * FROM inventory";
              $result = $conn-> query($sql);
              while ($row=$result->fetch_assoc()) {
                if($row["status_order"]=="Need To Order"){
                ?>  
                  <tr>  
                  <td><?php echo $row['product_id'] ?></td>  
                  <td><?php echo $row['instock_qty'] ?></td>
                  <td><?php echo $row['reorder_point'] ?></td>  
                  <td><?php echo $row['lead_time'] ?></td>
                  <td>
                        <select onchange="status_update(this.options[this.selectedIndex].value,'<?php echo $row['product_id'] ?>')">  
                            <option value="Need To Order">Need To Order</option>  
                            <option value="Ordered">Ordered</option>  
                        </select>  
                      </td>  
                  </tr>
                <?php }
                else if($row["status_order"]=="Ordered"){  ?>
                  <tr>  
                  <td><?php echo $row['product_id'] ?></td>  
                  <td><?php echo $row['instock_qty'] ?></td>
                  <td><?php echo $row['reorder_point'] ?></td>  
                  <td><?php echo $row['lead_time'] ?></td>
                  <td>
                        <select onchange="status_update(this.options[this.selectedIndex].value,'<?php echo $row['product_id'] ?>')">  
                          <option value="Ordered">Ordered</option>    
                          <option value="Need To Order">Need To Order</option>  
                        </select>  
                      </td>  
                  </tr>   
                
           <?php      }}  
            } ?>  







        </tbody>
    </table>
    <script type="text/javascript">  
      function status_update(value,product_id){  
           let url = "http://win.ie.eng.chula.ac.th/~tuesday_2023/T1/Finished/9_stock_order.php";  
           window.location.href= url+"?product_id="+product_id+"&status_order="+value;  
      }  
 </script> 
    <div class="bottom_line">
        <button type="button" class="button1" onclick="window.location.href='7_stockDesktop.php'">
          <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
          <div>Return</div>
        </button>
      </div>
</body>
</html>