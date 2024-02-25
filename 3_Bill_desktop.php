<?php
session_start();
include("connection.php");
$initG = 0;
$n=0;
$queryMAX = "SELECT MAX(bill_id) as last_bill_id FROM bill ";
$result_last_bill_id = mysqli_query($conn, $queryMAX); 
$rowMAX = mysqli_fetch_assoc($result_last_bill_id);
$max = $rowMAX['last_bill_id'];




if (isset($_GET['bill_id'])) {
  $b_id = $_GET['bill_id'];
  $query2 = "SELECT total FROM bill WHERE bill_id='$b_id'";
  $result2 = mysqli_query($conn, $query2);
  if($result2){
  $row = mysqli_fetch_assoc($result2);
  $initG = $row['total'];
  }
}
else {
   $b_id = -1;
}
$query1 = "SELECT bill.customer_id FROM bill where bill_id=$max";
$result1 = mysqli_query($conn, $query1);
if($result1){
$row1 = mysqli_fetch_assoc($result1);
$customer_id = $row1['customer_id'];

if($b_id == $max){//cus=0?
  $n=1;
}
}
echo "<script> var initG =".$initG."</script>";

echo "<script> var b_id =".$b_id."</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Interface</title>
    <link rel = "stylesheet" href = "Bill_desktop_Decor.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

var n = 0;
var remark = "";
console.log(b_id);
//console.log(initG);
document.addEventListener('DOMContentLoaded', initializeTable);

var tableBody = document.querySelector('.item-table tbody');
var rowCount = 0;
var oldTotal=0;

// $.ajax({
//     url: "billCon.php",
//     method: "POST",
//     data: { input: input },
//     success: function(data) {
//       var parsedData = JSON.parse(data);
//       $("#name"+remark).text(parsedData[0].name);
//       $("#type"+remark).text(parsedData[0].type);
//       $("#price"+remark).text("$" + parsedData[0].price);
//       console.log(remark);
//       tableBody = document.querySelector('.item-table tbody');
//       rowCount = tableBody.rows.length;

//       update(tableBody, rowCount);
//     }
//   });

function addNewItem() {
  var tableBody = document.querySelector('.item-table tbody');
  var newRow = tableBody.insertRow(-1);
  var namen = "";
  var typen = "";
  var pricen = "";
  newRow.innerHTML = `
    <tr>
      <td><input type="text" id = "`+n+`" onkeyup = "addRemark(this.id)" class = "id-input" style = "width: 70%"></td>
      <td id ="name`+n+`"></td>
      <td id ="type`+n+`"></td>
      <td class="price" id="price`+n+`">$</td>
      <td><input type="number" class="sub-discount" style = "width: 70%" value="0" min="0" onkeyup = "updateFromKey()" onclick = "updateFromKey()"></td>
      <td><input type="number" class="quantity" style = "width: 70%" value="1" min="1" onkeyup = "updateFromKey()" onclick = "updateFromKey()"></td>
      <td class="sub-total">$0.00</td>
    </tr>
  `;
  n+=1;
}
var c =0;
function count(){
  c++;
}

function countOld(x){
  console.log(x);
  //return x;
}

function removeItem() {
    var tableBody = document.querySelector('.item-table tbody');
    if (tableBody.rows.length > c) { // Ensure there is more than one row to remove
      tableBody.deleteRow(-1);
      for (var i = 0; i < rowCount; i++) {
        var row = tableBody.rows[i];
        updateSubTotalAndGrandTotal(row); 
      }
    }
  }

function initializeTable() {
  document.querySelectorAll('.item-table tbody tr').forEach(function(row) {
    // Add event listeners for quantity and sub-discount inputs
  });
}

function addRemark(thisID){
  remark=thisID;
  var input = document.getElementById(thisID).value;
  //console.log(input);
  $.ajax({
    url: "billCon.php",
    method: "POST",
    data: { input: input },
    success: function(data) {
      var parsedData = JSON.parse(data);
      $("#name"+remark).text(parsedData[0].name);
      $("#type"+remark).text(parsedData[0].type);
      $("#price"+remark).text("$" + parsedData[0].price);
      //console.log(remark);
      tableBody = document.querySelector('.item-table tbody');
      rowCount = tableBody.rows.length;

      update(tableBody, rowCount);
    }
  });
}

function update (tableBody, rowCount){
  for (var i = c; i < rowCount; i++) {
    var row = tableBody.rows[i];
    updateSubTotalAndGrandTotal(row);
    
  }
}

function updateFromKey (){
    tableBody = document.querySelector('.item-table tbody');
    rowCount = tableBody.rows.length;
    //gloGrandTotal = grandTotal;
    update(tableBody, rowCount);
}

function updateSubTotalAndGrandTotal(row) {
  // Get the price and sub-discount from the row
  var price = parseFloat(row.querySelector('.price').textContent.replace('$', ''));
  var subDiscount = parseFloat(row.querySelector('.sub-discount').value);
  var quantity = parseFloat(row.querySelector('.quantity').value);

  // Calculate the new subtotal for the row
  var subtotal = (price * quantity) - (subDiscount * quantity);

  // Update the subtotal field in the row
  row.querySelector('.sub-total').textContent = `$${subtotal.toFixed(2)}`;

  // Now, update the grand total
  var grandTotal = initG; // Initialize the grand total
  var subTotals = document.querySelectorAll('.sub-total'); // Select all subtotal elements

  // Loop through each subtotal element and add its value to the grand total
  subTotals.forEach(function(subTotal) {
    var value = parseFloat(subTotal.textContent.replace('$', '')); // Remove the dollar sign and convert to float
    if (!isNaN(value)) { // Check if the value is a number
      grandTotal += value; // Add to the grand total
    }
  });

  grandTotal -= document.getElementById("discount").value;

  gloGrandTotal = grandTotal;
  // window.location.href="3_Bill_desktop.php?gloGrandTotal=1";
  // Update the grand total display
  document.querySelector('.total-amount').textContent = `$${grandTotal.toFixed(2)}`;
  
}

function processBill() {
    var tableBody = document.querySelector('.item-table tbody');
    var rows = tableBody.querySelectorAll('tr');
    var items = [];
    var count = 0;
    rows.forEach(function (row) {
      count++;
      if(count>c){
        var id = row.querySelector('.id-input').value;
        var price = row.querySelector('.price').value;
        var quantity = row.querySelector('.quantity').value;
        var subDiscount = row.querySelector('.sub-discount').value;
        console.log(b_id);
        items.push({
            id: id,
            price: price,
            quantity: quantity,
            subDiscount: subDiscount,
            b_id: b_id,
            gloGrandTotal: gloGrandTotal
            // Include other necessary data from the row
        });
      }
    });
    
    
    // Send data to the server using AJAX
    $.ajax({
        url: "processBill.php",
        method: "POST",
        data: {
            items: items,
            //b_id: b_id
        },
        success: function (data) {
            var billId = data;
            //console.log("Dick Head")
            location.replace("http://win.ie.eng.chula.ac.th/~tuesday_2023/T1/Finished/15_Billing_Summary.php?bill_id-"+billId);
        },
        error: function () {
            console.error('Error processing bill');
        }
    });

}
function processEmb() {
    var tableBody = document.querySelector('.item-table tbody');
    var rows = tableBody.querySelectorAll('tr');
    var items = [];
    
    rows.forEach(function (row) {
        var id = row.querySelector('.id-input').value;
        var price = row.querySelector('.price').value;
        var quantity = row.querySelector('.quantity').value;
        var subDiscount = row.querySelector('.sub-discount').value;

        items.push({
            id: id,
            price: price,
            quantity: quantity,
            subDiscount: subDiscount
        });
    });

    $.ajax({
        url: "processBill.php",
        method: "POST",
        data: {
            items: items
        },
        success: function (data) {
            var billId = data;
            //console.log(billId);
            location.replace("http://win.ie.eng.chula.ac.th/~tuesday_2023/T1/Finished/4_embroidery_desktop.php?bill_id="+billId);
        },
        error: function () {
            console.error('Error processing bill');
        }
    });
    alert("Do you sure to go to Beta Webpage 4_embroidery_desktop.php?bill_id="+billId);
}

</script>
<body>
  <from method = "post">
    <div class = "flex-container" style="margin-bottom: 1%;">
      <div class = "gt_background">
        <br>
        <div class = "grand_total">Grand Total</div>
        <div class = "expense"><span class="total-amount"></span></div>
      </div>
      <div class = "user_background">
        <br>
        <div class = "user">User : Cashier 1</div>
      </div>
    </div>
    <table class="item-table">
      <thead>
        <tr>
          <th style = "width: 13%">Product ID</th>
          <th style = "width: 22%">Product Name</th>
          <th style = "width: 10%">Type</th>
          <th style = "width: 10%">Price</th>
          <th style = "width: 10%">Sub-Discount</th>
          <th style = "width: 5%">Quantity</th>
          <th style = "width: 10%">Sub-Total</th>
        </tr>
      </thead>
      <tbody>
      <?php
      if($n==1){
        $sql = "SELECT * FROM transactions JOIN price ON price.product_id = transactions.product_id WHERE bill_id=$max";
        $result = $conn-> query($sql);
        while ($row=$result->fetch_assoc()) {
          ?>
            <tr>  
            <td><?php echo $row['product_id'] ?></td>  
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['type'] ?></td>
            <td><?php echo $row['price'] ?></td>
            <td><?php echo $row['discount_unit'] ?></td>
            <td><?php echo $row['sale_qty'] ?></td>
            <td><?php echo $row['sale_qty']*($row['price']-$row['discount_unit']) ?></td>
            <?php echo "<script> count(); </script>"; ?>
            </tr>
      <?php
        }
      }
      ?>
      </tbody>
    </table>
    <div class = "bottom_line">
      <button class="buttonStyle" onclick="window.location.href='2_CashierDesktop.php'">
        <img src="./iconarrowright_.svg" style="width: 20px">
        Return 
      </button>
      <button id = "addItemButton" class = "buttonStyle" onclick="addNewItem()">Add Item</button>
		  <button id = "removeItemButton" class = "buttonStyle" onclick="removeItem()">Remove Item</button>
		  <div class = "total_discount_container">
        <div style = "font-size: 20px">Total Discount</div>
        <input id = "discount" class = "inputBox" style = "width: 200px" placeholder="$0.00" onkeyup = "updateFromKey()">
      </div>
        <!-- <button class = "buttonStyle" style = "width: 300px" onclick="processEmb()">
          Edit Embroidery
          <img src="./iconarrowright_.svg" style="width: 20px; transform: rotate(180deg);">
        </button> -->
        <button class = "buttonStyle" onclick = "processBill()">
          Bill Check
          <img src="./iconarrowright_.svg" style="width: 20px; transform: rotate(180deg);">
        </button>
      </div>
    </div>
  </from>
    
</body>
</html>