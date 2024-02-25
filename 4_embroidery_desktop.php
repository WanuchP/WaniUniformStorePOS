<?php
require "connection.php";
if (isset($_GET['embroideryID'])) {
  $billID = $_GET['embroideryID'];
} else {
   $billID = "Embroidery ID not found in URL";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./embroidery_Decor.css">
</head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
function addAllBT() {
    const selectAllCheckbox = document.querySelector('input[type="checkbox"]');
    const checkboxes = document.querySelectorAll('input[class="selectBoxList"]');
    const selectedEmbroideryIDs = [];
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            const embroideryID = checkbox.parentNode.parentNode.lastChild.textContent;
            selectedEmbroideryIDs.push(embroideryID);
        }
    });

    if (selectedEmbroideryIDs.length > 0) {
        const detailLink = `5_Embroidery_detail_beta.php?embroideryID=${selectedEmbroideryIDs.join(',')}`;
        window.location.href = detailLink;
    } else {
        alert('Please select at least one embroidery item to add details for.');
    }
    selectAllCheckbox.addEventListener('change', function() {
        const checked = this.checked;
        checkboxes.forEach(function(checkbox) {
        checkbox.checked = checked;
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {

    // $.ajax({
    //     url: "a_embroidery_desktop.php",
    //     success: function (data) {
    //         console.log(data);
    //         var rawdata = JSON.parse(data);
    //         var startID = 1;
    //         console.log(rawdata);
    //         rawdata[0].forEach(item => {
    //             addRow(item);
    //             startID += 1;
    //         });

    //     },
    //     error: function () {
    //         console.error('Error processing bill');
    //     }
    // });

    data = [
        {product:"เสื้อนักเรียนชายตัวที่ 1", order_id: 12, embroidery_id: "EM-00001"},
        {product:"เสื้อนักเรียนชายตัวที่ 2", order_id: 12, embroidery_id: "EM-00002"},
        {product:"เสื้อนักเรียนชายตัวที่ 3", order_id: 12, embroidery_id: "EM-00003"},
        {product:"เสื้อลูกเสือ", order_id: 13, embroidery_id: "EM-00004"},
        {product:"ผ้าเช็ดหน้า", order_id: 18, embroidery_id: "EM-00005"},
    ];

    data.forEach(item => {
        addRow(item);
        //startID += 1;
    });
    
    
    const selectAllCheckbox = document.querySelector('input[type="checkbox"]');
    const checkboxes = document.querySelectorAll('input[class="selectBoxList"]');

selectAllCheckbox.addEventListener('change', function() {
    const checked = this.checked;
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = checked;
    });
});            

function addRow(data) {
    const table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow(table.rows.length);

    const selectBox = newRow.insertCell(0);            
    const slBox = document.createElement('INPUT');
    slBox.setAttribute("type", "checkbox");
    slBox.className = "selectBoxList";
    slBox.style =  "text-align: left;";
    selectBox.appendChild(slBox);

    // const pd = newRow.insertCell(1);
    // const divPd = document.createElement('INPUT')
    // divPd.setAttribute("type", "text");
    // divPd.className = "typeBox";
    // pd.appendChild(divPd);
    const orid = newRow.insertCell(1);
    const divOrid = document.createElement('DIV')
    const t2 = document.createTextNode(data.order_id);
    divOrid.appendChild(t2);
    divOrid.style = "text-align: center;";
    orid.appendChild(divOrid);

    const pd = newRow.insertCell(2);
    const divPd = document.createElement('DIV')
    const t1 = document.createTextNode(data.product);
    divPd.appendChild(t1);
    divPd.style = "text-align: left;";
    pd.appendChild(divPd);

    const detailButton = newRow.insertCell(3);
    const deBut = document.createElement('BUTTON');
    const t3 = document.createTextNode("See Detail");
    deBut.appendChild(t3);
    deBut.className = "seeDetail";
    const embroideryID = data.embroidery_id;
    const detailLink = `5_Embroidery_detail_beta.php?embroideryID=${embroideryID}`;
    deBut.setAttribute("onclick", `window.location.href='${detailLink}'`);
    detailButton.appendChild(deBut);

    const eid = newRow.insertCell(4);
    const divEid = document.createElement('DIV')
    const t4 = document.createTextNode(data.embroidery_id);
    divEid.appendChild(t4);
    divEid.style = "text-align: center;";
    eid.appendChild(divEid);
}
});
</script>

<body style="background-color:#F2F2F2;">
    
    <div class = "flex-container">
        <div class = "title">
            <br>
            <div class = "embroidery">Embroidery</div>
        </div>
        <div class = "user_background">
            <br>
            <div class = "user">User : Cashier 1</div>
        </div>
    </div>
    <div class="flex-container" style="gap: 5px; width: 100%;">
        <input type="checkbox" style="align-items: center; margin-left: 70%;">
        <div style="display: flex; align-items: center;">Select All</div>
        <button class="addDetail" onclick="addAllBT()">Add Detail for Selected</button>
    </div>

    <table style="width: 100%;" id="dataTable">
        <thead>
        <tr style="border-bottom:2px solid black; font-size: 24px; height: 30px;">
            <th style="width: 10%;">Select</th>
            <th style="width: 20%;">Order ID</th>
            <th style="width: 30%; text-align: left;">Product Name</th>
            <th style="width: 20%;"></th>
            <th style="width: 20%;">EmbroideryID</th>
        </tr>
        </thead>
        <tbody>    
            <?php
            include "a_embroidery_desktop.php";
            ?>
        </tbody>
    </table>
    <div class="bottom_line">
        <button type="button" class="buttonStyle" style = "margin-left: 5%" onclick="window.location.href='3_Bill_desktop.php?bill_id-'">
            <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
            <div>Return</div>
        </button>
        <button type="button" class="buttonStyle" style = "margin-left: 60%" onclick="window.location.href='3_Bill_desktop.php?bill_id-'">
            <div>Complete</div>
            <div><img src="icon _arrow right 1_.png" style="width: 25px;"></div>
        </button>
     </div>
</body>
</html>