<?php
session_start();
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS Interface</title>
  <link rel="stylesheet" href="Bill_desktop.css">
<style>
   @import url('https://fonts.googleapis.com/css2?family=Inria+Sans&display=swap');
</style>
<script>
// Inside your event listener setup
// input.addEventListener('input', function() {
//   updateSubTotalAndGrandTotal(row);
//   updateTotalDiscount(); // Call this to update the total discount
// });
var gloGrandTotal = 0;


function processBill() {
    var tableBody = document.querySelector('.item-table tbody');
    var rows = tableBody.querySelectorAll('tr');
    var items = [];

    rows.forEach(function (row) {
        var id = row.querySelector('.id input').value;
        var price = row.querySelector('.price').value;
        var quantity = row.querySelector('.quantity').value;
        var subDiscount = row.querySelector('.sub-discount').value;

        items.push({
            id: id,
            price: price,
            quantity: quantity,
            subDiscount: subDiscount
            // Include other necessary data from the row
        });
    });

    // Send data to the server using AJAX
    $.ajax({
        url: "processBill.php",
        method: "POST",
        data: {
            items: items
            // Include other necessary data
        },
        success: function (data) {
            var response = JSON.parse(data);

            if (response.success) {
                // Handle success (e.g., display a success message)
                console.log(response.message);
            } else {
                // Handle failure (e.g., display an error message)
                console.error(response.message);
            }
        },
        error: function () {
            // Handle AJAX error
            console.error('Error processing bill');
        }
    });
}

// document.querySelector('.bill-check').addEventListener('click', function () {
//     processBill();
// });

function handleclick (){
	var element = document.getElementById("discount");
	element.style.backgroundColor = 'red';
	element.value = 'hello';
}
// Function to update the sub-total for a given row and grand total
function updateSubTotalAndGrandTotal(row) {
  // Get the price and sub-discount from the row
  var price = parseFloat(row.querySelector('.price').textContent.replace('$', ''));
  var subDiscount = parseFloat(row.querySelector('.sub-discount').value);
  var quantity = parseFloat(row.querySelector('.quantity').value);

  // Calculate the new subtotal for the row
  var subtotal = (price * quantity) - subDiscount;

  // Update the subtotal field in the row
  row.querySelector('.sub-total').textContent = `$${subtotal.toFixed(2)}`;

  // Now, update the grand total
  var grandTotal = 0; // Initialize the grand total
  var subTotals = document.querySelectorAll('.sub-total'); // Select all subtotal elements

  // Loop through each subtotal element and add its value to the grand total
  subTotals.forEach(function(subTotal) {
    var value = parseFloat(subTotal.textContent.replace('$', '')); // Remove the dollar sign and convert to float
    if (!isNaN(value)) { // Check if the value is a number
      grandTotal += value; // Add to the grand total
  updateTotalDiscount();
    }
  });
  gloGrandTotal = grandTotal;
  // window.location.href="3_Bill_desktop.php?gloGrandTotal=1";
  // Update the grand total display
  document.querySelector('.total-amount').textContent = `$${grandTotal.toFixed(2)}`;
  
}

// Function to initialize the table and add event listeners
function initializeTable() {
  document.querySelectorAll('.item-table tbody tr').forEach(function(row) {
    // Add event listeners for quantity and sub-discount inputs
    row.querySelector('.quantity').addEventListener('input', function() {
      updateSubTotalAndGrandTotal(row);
    });
    row.querySelector('.sub-discount').addEventListener('input', function() {
      updateSubTotalAndGrandTotal(row);
    });
    // Initialize the subtotal for each row
    updateSubTotalAndGrandTotal(row);
  });
}
var n =0;
var remark="";

function addRemark(thisID){
  remark=thisID;
  $(document).ready(function() {
    $("#"+remark).keyup(function() {
      var input = $(this).val();
      $.ajax({
        url: "billCon.php",
        method: "POST",
        data: { input: input },
        success: function(data) {
          var parsedData = JSON.parse(data);

          // Update the elements with the data
          $("#name"+remark).text(parsedData[0].name);
          $("#type"+remark).text(parsedData[0].type);
          $("#price"+remark).text("$" + parsedData[0].price);
          console.log(remark);
          var tableBody = document.querySelector('.item-table tbody');
          var rowCount = tableBody.rows.length; // Get the number of rows in the table

          for (var i = 0; i < rowCount; i++) {
            var row = tableBody.rows[i];
            updateSubTotalAndGrandTotal(row);
          }

          updateTotalDiscount(); // Call this after updating all rows
        },
      });
    });
  });
  var tableBody = document.querySelector('.item-table tbody');
  var rowCount = tableBody.rows.length; // Get the number of rows in the table

  for (var i = 0; i < rowCount; i++) {
    var row = tableBody.rows[i];
    updateSubTotalAndGrandTotal(row);
  }

  updateTotalDiscount(); // Call this after updating all rows
    // var tableBody = document.querySelector('.item-table tbody');
    // for (var i = 0; i < remark; i++) {
    //   var row = tableBody.row[i];
    //   updateSubTotalAndGrandTotal(row);
    //   updateTotalDiscount();
    // }
    // document.querySelectorAll('.item-table tbody tr').forEach(function(row) {
    //   // Add event listeners for quantity and sub-discount inputs
    //   row.querySelector('.form-control').addEventListener('input', function() {
    //     updateSubTotalAndGrandTotal(row);
    //   });
    // });
}
// Initialize the table when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initializeTable);
function addNewItem() {
  var tableBody = document.querySelector('.item-table tbody');
  var newRow = tableBody.insertRow(-1);
  var namen = "";
  var typen = "";
  var pricen = "";
  newRow.innerHTML = `
    <tr>
      <td class="id"><input type="text" id = "`+n+`" onclick = "addRemark(this.id)" class = "form-control"></td>
      <td class="name" id ="name`+n+`"></td>
      <td class="type" id ="type`+n+`"></td>
      <td class="price" id="price`+n+`">$</td>
      <td><input type="number" class="sub-discount" value="0" min="0"></td>
      <td><input type="number" class="quantity" value="1" min="1"></td>
      <td class="sub-total">$0.00</td>
    </tr>
  `;

  // Add event listeners to the new inputs
  newRow.querySelector('.quantity').addEventListener('input', function() {
    updateSubTotalAndGrandTotal(newRow);
  });
  newRow.querySelector('.sub-discount').addEventListener('input', function() {
    updateSubTotalAndGrandTotal(newRow);
  });
  // Initialize the subtotal for the new row
  updateSubTotalAndGrandTotal(newRow);
  updateTotalDiscount();
  //n+=1;
  n+=1;
  var tableBody = document.querySelector('.item-table tbody');
  var rowCount = tableBody.rows.length; // Get the number of rows in the table

  for (var i = 0; i < rowCount; i++) {
    var row = tableBody.rows[i];
    updateSubTotalAndGrandTotal(row);
  }

  updateTotalDiscount(); // Call this after updating all rows
}
	  // Function to remove the last item row
  function removeItem() {
    var tableBody = document.querySelector('.item-table tbody');
    if (tableBody.rows.length > 1) { // Ensure there is more than one row to remove
      tableBody.deleteRow(-1);
      updateGrandTotal(); // Update the grand total after removing a row
    }
    updateTotalDiscount();
  }
  function updateTotalDiscount() {
  var totalDiscount = 0; // Initialize the total discount
  var discountInputs = document.querySelectorAll('.sub-discount'); // Select all discount inputs

  // Loop through each discount input and add its value to the total discount
  discountInputs.forEach(function(input) {
    var discountValue = parseFloat(input.value);
    if (!isNaN(discountValue)) { // Check if the value is a number
      totalDiscount += discountValue; // Add to the total discount
    }
  });

  // Update the total discount input field
  var totalDiscountInput = document.getElementById('discount');
  if (totalDiscountInput) {
    totalDiscountInput.value = totalDiscount.toFixed(2);
  }
}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <script type="text/javascript">
         
      </script>
</head>
<body>

  <form action="" method="post">
<div class="pos-container">
  <div class = 'superhead'>
    <div class="header" >
        <div class = "gt_background">
            <br>
        <div class="grand-total">Grand Total </div>
        <div class = "expense"><span class="total-amount"></span></div>
        </div>
    </div>
    <div class="user-info">
            User: <span class="username">Cashier1</span>
        </div>
        </div>
  
        <table class="item-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price <?php echo "xxx" ?></th>
                    <th>Sub-Discount</th>
                    <th>Quantity</th>
                    <th>Sub-Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row for Student Shirt -->
                <!-- Repeat rows for other items -->
            </tbody>
        </table>

</div>
	  <div class="actions">

		    <button type="button" class="return" onclick="window.location.href='2_CashierDesktop.php'">
        <img src="./iconarrowright_.svg" style="width: 20px">
        Return 
        </button>
        <input type="text" id="live_search" name="live_search">
        
			<div>
		    <button id="addItemButton"; style="btext-align: left; width: 130px; height: 35px;flex-shrink: 0; border-radius: 10px; background: #D9D9D9;box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);" onclick="addNewItem() ">Add Item</button>
		    <button id="removeItemButton"; style="btext-align: left; width: 130px; height: 35px;flex-shrink: 0; border-radius: 10px; background: #D9D9D9;box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);" onclick="removeItem()">Remove Item</button></div>
		    <div class="total-discount-container">
              <div class="total-discount-label">Total Discount</div>
              <input id="discount" placeholder="$0.00">
    
            <button type="button" class="edit-embroidery" onclick="window.location.href='4_embroidery_desktop.php'">Edit Embroidery
            <img src="./iconarrowright_.svg" style="width: 20px; transform: rotate(180deg);">
            </button>
              <input type="submit" name="submit" value="BillCheck">
        <!-- <img src="./iconarrowright_.svg" style="width: 20px; transform: rotate(180deg); text-align: right"> -->
    </button>
</form>

        </div>
        <?php
include("connection.php");

//$gloGrandTotal = $_COOKIE["gloGrandTotal"];
$gloGrandTotal = 4;

if (isset($_POST["submit"])) {
  // Assuming that you have a database connection already established with $conn
  // Get the gloGrandTotal from the POST data

  // Get the maxBillId
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

</body>
</html>

