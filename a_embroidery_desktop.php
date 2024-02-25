<?php
    require 'connection.php';
    $data = [];
    if (isset($_GET['bill_id'])) {
        $lastem = 0;
        $bill_ID = $_GET['bill_id'];
        
        $querylastem = "SELECT MAX(embroidery_id) as lastem FROM embroidery_id"; 
        $resultlastem = mysqli_query($conn, $querylastem); 
        if ($resultlastem) {
            $row2 = mysqli_fetch_array($resultlastem);
            $lastem = $row2['lastem'];
        }
        

        $sql = "SELECT p.name as name, t.order_id as order_id FROM transactions t, price p 
                where t.product_id = p.product_id and t.bill_id = '$bill_ID'";
        $result = $conn-> query($sql);
        if(mysqli_num_rows($result) > 0){
            // Iterate through each row in the result set
            while ($row = mysqli_fetch_assoc($result)) {
                $lastem += 1;
            // Create an array for the current row
                $data[] = [
                    "product" => $row['name'],
                    "order_id" => $row['order_id'],
                    "embroidery_id" => $lastem,
                ];
                // Add the current row's array to the list of all arrays
            }
        }
    } else {
        $bill_ID = "Embroidery ID not found in URL";
    }
    echo json_encode($data);
?>