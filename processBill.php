<?php
// Include your database connection file
include("connection.php");
// Check if the 'items' data is received from the frontend
// if (isset($_POST['items']) || isset($_POST['b_id'])) {
if (isset($_POST['items'])) {
    $items = $_REQUEST['items'];
    // $b_id = $_REQUEST['b_id'];
    foreach ($items as $item) {
        $b_id = $item['b_id'];
        $total = $item['gloGrandTotal'];
    }
    $query = "SELECT MAX(bill_id) as maxBillId FROM bill";
    $result = mysqli_query($conn, $query);
    //$customerId = 10;

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $maxBillId = $row['maxBillId'];
    }

    // $query = "SELECT detail FROM bill WHERE bill_id = '$maxBillId'";
    // $result = mysqli_query($conn, $query);
    // if ($result) {
    //     $row = mysqli_fetch_assoc($result);
    //     $customerId = $row['detail'];
    // }

    if ($b_id==$maxBillId) {
    $grandTotal = 0;
    $billId = $maxBillId;

    $query = "SELECT total FROM bill WHERE bill_id='$billId'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $grandTotal = $row['total'];
    }

    $query = "SELECT MAX(order_id) as maxOrderId FROM transactions";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $orderId = $row['maxOrderId'] + 1;
    } else {
        // Handle the error
        die("Error getting order_id: " . mysqli_error($conn));
    }

    // Insert each item into the transaction table
    foreach ($items as $item) {
        $itemId = $item['id'];
        //$price = $item['price']
        $quantity = $item['quantity'];
        $subDiscount = $item['subDiscount'];



        $query = "SELECT price FROM price WHERE product_id='$itemId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $price = $row['price'];
        } else {
            // Handle the error
            die("Error getting price: " . mysqli_error($conn));
        }

        // Perform any additional processing or validation if needed
        $grandTotal += ($price-$subDiscount)*$quantity;
        $unit_price = ($price-$subDiscount)*$quantity;
        $insertQuery = "INSERT INTO transactions (bill_id, order_id, product_id, order_price, discount_unit, sale_qty, sale_channel) 
                        VALUES ('$billId','$orderId', '$itemId','$unit_price', '$subDiscount','$quantity','')";
        $orderId += 1;
        // Execute the SQL query
        $insertResult = mysqli_query($conn, $insertQuery);

        $stockQuery = "SELECT * FROM inventory WHERE product_id = '$itemId'";
        $stockResult = mysqli_query($conn, $stockQuery);
        if ($stockResult) {
            $row = mysqli_fetch_assoc($stockResult);
            $instock = $row['instock_qty'];
        }
        $newStock = $instock-$quantity;
        $removeStock = "UPDATE inventory SET instock_qty = '$newStock' WHERE product_id = '$itemId'";
        $removeResult = mysqli_query($conn, $removeStock);
        if (!$insertResult) {
            // Handle the error
            die("Error inserting item: " . mysqli_error($conn));
        }
    }
    $grandTotal = $total;
    $insertQuery = "UPDATE bill SET total = '$grandTotal' WHERE bill_id = '$billId'";
    $insertResult = mysqli_query($conn, $insertQuery);
    }   
//-------------------------------------------------------------------------------------------------------------
 else {
        // Get the items data from the POST request
    $items = $_REQUEST['items'];
    $grandTotal = 0;
    $query = "SELECT MAX(bill_id) as maxBillId FROM transactions";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $billId = $row['maxBillId']+1;
    } else {
        // Handle the error
        die("Error getting bill_id: " . mysqli_error($conn));
    }

    $query = "SELECT MAX(order_id) as maxOrderId FROM transactions";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $orderId = $row['maxOrderId'] + 1;
    } else {
        // Handle the error
        die("Error getting order_id: " . mysqli_error($conn));
    }
    // Insert each item into the transaction table
    foreach ($items as $item) {
        $itemId = $item['id'];
        //$price = $item['price']
        $quantity = $item['quantity'];
        $subDiscount = $item['subDiscount'];
        $total = $item['gloGrandTotal'];

        $query = "SELECT price FROM price WHERE product_id='$itemId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $price = $row['price'];
        } else {
            // Handle the error
            die("Error getting price: " . mysqli_error($conn));
        }

        // Perform any additional processing or validation if needed
        $grandTotal += ($price-$subDiscount)*$quantity;
        $unit_price = ($price-$subDiscount)*$quantity;
        $insertQuery = "INSERT INTO transactions (bill_id, order_id, product_id, order_price, discount_unit, sale_qty, sale_channel) 
                        VALUES ('$billId','$orderId', '$itemId','$unit_price', '$subDiscount','$quantity','')";
        $orderId += 1;
        // Execute the SQL query
        $stockQuery = "SELECT * FROM inventory WHERE product_id = '$itemId'";
        $stockResult = mysqli_query($conn, $stockQuery);
        if ($stockResult) {
            $row = mysqli_fetch_assoc($stockResult);
            $instock = $row['instock_qty'];
        }
        $newStock = $instock-$quantity;
        $removeStock = "UPDATE inventory SET instock_qty = '$newStock' WHERE product_id = '$itemId'";
        $removeResult = mysqli_query($conn, $removeStock);
        $insertResult = mysqli_query($conn, $insertQuery);
        // $stockQuery = "SELECT * FROM inventory WHERE product_id = '$itemId'";
        // $stockResult = mysqli_query($conn, $query);
        // if ($stockResult) {
        //     $row = mysqli_fetch_assoc($stockResult);
        //     $instock = $row['instock_qty'];
        // }
        // $newStock = $instock-$quantity
        // $removeStock = "UPDATE inventory SET instock_qty = '$newStock' WHERE product_id = '$itemId'";
        // if (!$insertResult) {
        //     // Handle the error
        //     die("Error inserting item: " . mysqli_error($conn));
        // }
    }
    $grandTotal = $total;
    $insertQuery = "INSERT INTO `bill` (`bill_id`, `tax`, `pickup_date`, `detail`, `total`, `customer_id`, `status_booking`) VALUES ('$billId', '', '', '', '$grandTotal', '', 'Not Recieved Yet')";
    $insertResult = mysqli_query($conn, $insertQuery);
    
    }
    

        // if (!$insertResult) {
        //     // Handle the error
        //     die("Error inserting item: " . mysqli_error($conn));
        // }
    //echo 123;
    //echo '<script>console.log("ควย");</script>';
    echo $billId;
    //echo '<script>console.log('.$billId.');</script>';
    mysqli_close($conn);
//      echo '<script>window.location.replace = "15_Billing_Summary.php";</script>';
//  exit();
// header("Location: 15_Billing_Summary.php");
}

//header("Location: 15_Billing_Summary.php");
// Close the database connection
?>



