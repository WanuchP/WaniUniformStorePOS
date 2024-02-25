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
  <link rel="stylesheet" type = "text/css" href="styles_stock_info.css">
  

</head>
<body style="background-color:#F2F2F2;">
  <div class="user">
      <div>User: Stock1</div>
  </div>
  <div class="title">Inventory</div>
  <br>
  <br>
  <table >
    <table style="width: 100%;" id="dataTable">
        <thead>
        <tr>
            <th style="width: 20%;">Product Id</th>
            <th style="width: 20%;">Product Name</th>
            <th style="width: 20%;">Instock Qty</th>
            <th style="width: 20%;">Reorder Point</th>
            <th style="width: 20%;">Lead Time</th>
        </tr>
        </thead>
        <tbody >

  <?php
  $sname= "127.0.0.1";
  $uname= "t66g1";
  $password = "t66g1";
  $db_name = "t66g1";
  $conn = mysqli_connect($sname, $uname, $password, $db_name);
  if (!$conn) {
      echo "Connection failed!";
  }
  $sql = "SELECT * FROM inventory";
  $result = $conn-> query($sql);
  if ($result-> num_rows > 0){
    while ($row = $result->fetch_assoc()){
      echo "<tr><td>".
            $row["product_id"]."</td><td>".
            $row["product_name"]."</td><td>".
            $row["instock_qty"]."</td><td>".
            $row["reorder_point"]."</td><td>".
            $row["lead_time"]."</td><td>".
            "</td></tr>";
    }
    echo "</table>";
  }
  else{
    echo "0 result";
  }

  $conn->close();
?>
        </tbody>

    </table>


  <div class="bottom_line">
      <button type="button" class="button1" onclick="window.location.href='7_stockDesktop.php'">
        <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
        <div>Return</div>
      </button>
  </div>
  <br>

  <br><br>

</body>
</html>