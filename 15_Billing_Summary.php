<?php
if (isset($_GET['bill_id'])) {
  $b_id = $_GET['bill_id'];
}
else {
   $b_id = -1;
}
echo "<script> var b_id =".$b_id."</script>"
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Summary</title>
    <link rel="stylesheet" href="./15_Billing_Summary_Decor.css">
</head>

<body>
    <div class = "flex-container" style="margin-bottom: 1%;">
        <div class = "gt_background">
            <br>
            <div class = "grand_total">Grand Total</div>
            <div class = "expense">
<!-- ---------------------------------------------------------- -->
            <?php
                require_once 'connection.php';
                $queryMAX = "SELECT MAX(bill_id) as last_bill_id FROM bill ";
                $result_last_bill_id = mysqli_query($conn, $queryMAX); 
                $rowMAX = mysqli_fetch_array($result_last_bill_id);
                $last_bill_id = $rowMAX['last_bill_id'];

                $queryMAX2 = "SELECT bill.total FROM bill where bill_id = $last_bill_id"; 
                $resultLast = mysqli_query($conn, $queryMAX2); 
                $rowMAX2 = mysqli_fetch_array($resultLast);
                $total = $rowMAX2['total'];
                echo $total; 
            ?>
<!-- ---------------------------------------------------------- -->

            </div>
        </div>
        <div class = "user_background">
            <br>
            <div class = "user">User : Cashier 1</div>
        </div>
    </div>
    <table>
        <tr> 
            <th style="width: 60%;">
                <form method="post" >
                    <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Customer ID:</div>
                        <input type="text" name="customerid" value="" placeholder = "Customer ID.." class="input1"  >
                    </div>
                    <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Customer Name:</div>
                        <input type="text" name="name" value="" placeholder = "Name.." class="input1" required>
                    </div>
                    <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Customer Address:</div>
                        <input type="text" name="address" value="" placeholder = "Address.." class="input1" >
                    </div>
                    <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Taxpayer Identification No.:</div>
                        <input type="text" name = "tax" value="" placeholder = "Tax No. .." class="input1" >
                    </div>
                    <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Pick Up Date</div>
                        <input type="Date" name="date" value="" class="input1" >
                    </div>
                    <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Phone Number:</div>
                        <input type="text" name="phone" value="" placeholder = "Phone Number.." class="input1" >
                    </div>
                    <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Order Config:</div>
                        <input type="text" name="detail" value="" placeholder = "Detail in Tax Bill.." class="input1">
                    </div>
                    <!-- <div class="flex-container" style="margin-bottom: 1.5%;">
                        <div class = "bodyfont">Expense Config:</div>
                        <input type="text" name="total" value="" placeholder = "Grand Total in Tax Bill.." class="input1">
                    </div> -->
                    <!-- <div class="bottom_line" >
                        <button type="button" class="buttonStyle" style = "margin-left: 50%" name="ziin">
                            Submit
                        </button>
                    </div> -->
                    <div class="bottom_line">
                        <button type="button" class="buttonStyle"  onclick="returnbt()">
                            <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
                            <div>Return</div>
                        </button>
                        <button type="submit" name="submit" class="buttonStyle" >
                            <div>Update data</div>
                        </button>
                        <button type="button" class="buttonStyle" onclick="window.location.href='16_Saving_status.php'">
                            <div>Complete</div>
                            <div><img src="icon _arrow left 1_.png"  style="width: 25px; transform: rotate(180deg) "></div>
                        </button>
                    
                    </div>  
                </form>
            </th>
            <!-- <th style="width: 40%; align-items: center;">
                <div class = "flex-container" style = "margin-left: 10%; flex-direction: column;">
                    <button class = printButton>
                        Print Full Bill
                    </button>
                    <button class = printButton>
                        Print Embroidery List
                    </button>
                    <button class = printButton>
                        Print an Appointment
                    </button>
                    <button class = printButton>
                        Print Self Config Bill
                    </button>
                </div>
            </th> -->
        </tr>
    </table>
    <!-- <div class="bottom_line">
        <button type="button" class="buttonStyle" style = "margin-left: 5%" onclick="window.location.href='3_Bill_desktop.php'">
            <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
            <div>Return</div>
        </button>
        <button type="button" name="complete" class="buttonStyle" style = "margin-left: 65%" onclick="window.location.href='16_Saving_status.php'">
            <div>Complete</div>
            <div><img src="icon _arrow right 1_.png" style="width: 25px;"></div>
        </button>
        <form method="post" >
            <button type="button" name="complete" class="buttonStyle" style = "margin-left: 65%" onclick="insert(); window.location.href='16_Saving_status.php';">
                <div>Complete</div>
                <div><img src="icon _arrow right 1_.png" style="width: 25px;"></div>
            </button>
        </form>


     </div> -->
     <?php
    
    

    require_once 'connection.php';
    if(isset($_POST["submit"])){
        $customerid = $_REQUEST["customerid"];
        $name = $_REQUEST["name"];
        $address = $_REQUEST["address"];
        $tax = $_REQUEST["tax"];
        $date = $_REQUEST["date"];
        $phone = $_REQUEST["phone"];
        $detail = $_REQUEST["detail"];

        //check ว่า customer_id นี้มีหรือไม่
        //$queryselect2 = "SELECT customer_id FROM customer WHERE customer_id as recentid = $customerid";
        //$resultcustomerid = mysqli_query($conn, $queryselect2);
        //ถ้า  cusid = ''  ให้ทำการgen idใหม่ = lastid +=1
        //ถ้า cusid = 'something' ให้เก็บข้อมูลตามปกติ
        $queryselect3 = "SELECT MAX(customer_id) as lastid FROM customer ";
        $resultlastid = mysqli_query($conn, $queryselect3); 
        $row3 = mysqli_fetch_array($resultlastid);
        $lastid = $row3['lastid'];

        $querylastbill = "SELECT MAX(bill_id) as lastbill FROM bill"; 
        $resultlastbill = mysqli_query($conn, $querylastbill); 
        $row = mysqli_fetch_array($resultlastbill);
        // 3 ถ้า bill no เป็นค่าว่างให้เท่ากับ 1  ถ้าไม่ใช่ค่าว่าง ให้เอาเลขบิลล่าสุดไป +1
        $lastbill = $row['lastbill'];
        // if($lastbill==''){
	    //     $lastbill=1;
        // }else{
	    // $lastbill = ($lastbill + 1);
        // }
        //query เลขบิลลง database
        
        if($customerid == ""){
            $customerid = ($lastid+1);
            $queryinsertcus = "INSERT INTO customer VALUES ('$customerid','$name', '$phone', '$address')";
            $resultinsertcus = mysqli_query($conn, $queryinsertcus);
            echo "if";
        }
        else{
            $queryupdatecus = "UPDATE customer 
                               SET name ='$name', phone = '$phone', address = '$address'
                               WHERE customer_id = '$customerid'";
            $resultupdatecus = mysqli_query($conn, $queryupdatecus);
            echo "else";
        }
        $querytobill = "UPDATE bill 
                        SET tax = '$tax', pickup_date = '$date', detail ='$detail', customer_id = '$customerid', status_booking = 'Not Recieved Yet'
                        WHERE bill_id = $lastbill";
        $resulttobill = mysqli_query($conn, $querytobill);
        echo "bill"; 


       // header("Location: 16_Saving_status.php",true,301);
        exit();
            // echo
            // "
            // <script> alert('Data Insert Successfully')</scr>
            // ";
        }

?>
</body>

<script type="text/javascript">

    function returnbt() {
        const billID = '<?php echo "$last_bill_id";?>';
        window.location.href='3_Bill_desktop.php?bill_id='+billID;
    }

</script>

</html>