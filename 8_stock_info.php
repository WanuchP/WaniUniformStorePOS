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
  
  <script src="./jquery-3.7.1.min.js"></script>
  <script type = "text/javascript">
    // Function to update the data
    // function updateData() {
    //     $.ajax({
    //         url: 'stock_info_update.php',
    //         type: 'GET',
    //         success: function (data) {
    //             $('#update-container').html(data);
    //         }
    //     });
    //   }


    // Call the updateData function initially
    // updateData();

    // // Set interval to update data every 5 seconds (for example)
    // $('#update-button').on('click', function () {
    //     updateData();
    // });
    //setInterval(updateData, 1000);

    $(document).ready(function(){
      // function updateData() {
        $("#update-container").load("./stock_info_update.php")
        setInterval(function() {
            $.ajax({
              url: './stock_info_show.php',
              success: function (data) {
                  $('#update-container').load("./stock_info_show.php");
              }
          });
        }, 5);
      // }
    });
</script>

</head>
<body style="background-color:#F2F2F2;">
  <div class="user">
      <div>User: Stock1</div>
  </div>
  <div class="title">Add Stock</div>
  <br>
  <br>
  <form method = "post">
      <div class="add_info">
          <div>Product_ID:</div>
          <div><input type = "number"class="info_input" name= "product_id1"></div>
          <div>Date:</div>
          <div><input type = "date" class="info_input" name="date1"></div>
          <div>Cost_unit:</div>
          <div><input class="info_input" name="cost_unit1"></div>
          <div>Quantity:</div>
          <div><input class="info_input" name="qty1"></div>
          <div><input type="submit"  class="update_button" name="update" value="Update Data"></div>
      </div>
  </form>
  <table >
    <table style="width: 100%;" id="dataTable">
        <thead>
        <tr>
            <th style="width: 20%;">recieved_id</th>
            <th style="width: 20%;">product_id</th>
            <th style="width: 20%;">date</th>
            <th style="width: 20%;">cost_unit</th>
            <th style="width: 20%;">Quantity</th>
        </tr>
        </thead>
        <tbody id="update-container">
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

<?php
  include("connection.php");
  if (isset($_POST['update'])) {
    $querylastrec = "SELECT MAX(recieved_id) as recieved_id FROM recieved order by (recieved_id) DESC ";
    $resultlastrec = mysqli_query($conn, $querylastrec);
    $row = mysqli_fetch_array($resultlastrec);
    $lastrec =$row['recieved_id'];
    $lastrec += 1;
    $product_id = $_REQUEST['product_id1'];
    $date = $_REQUEST['date1'];
    $cost_unit = $_REQUEST['cost_unit1'];
    $qty = $_REQUEST['qty1'];
  
  $query1 = "INSERT INTO recieved Values('{$lastrec}'
            ,'{$product_id}'
            ,'{$date}'
            ,'{$cost_unit}'
            ,'{$qty}')"
            ;
   $query2 = "UPDATE inventory 
              SET instock_qty = $qty + instock_qty
              WHERE product_id = $product_id"

            ;
  $result1 = mysqli_query($conn, $query1);
  $result2 = mysqli_query($conn, $query2);

  
  mysqli_close($conn);
  }
?>    
</body>
</html>