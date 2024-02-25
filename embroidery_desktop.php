<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./embroidery_Decor.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const data =[
                { product: "เสื้อนักเรียนชาย", embroideryV: 30, embroideryID: "E000001" },
                { product: "เสื้อนักเรียนชาย", embroideryV: 30, embroideryID: "E000001" },
                { product: "เสื้อนักเรียนชาย", embroideryV: 30, embroideryID: "E000001" },
                { product: "เสื้อนักเรียนชาย", embroideryV: 30, embroideryID: "E000001" },
                { product: "เสื้อนักเรียนชาย", embroideryV: 30, embroideryID: "E000001" },
                { product: "เสื้อนักเรียนชาย", embroideryV: 30, embroideryID: "E000001" }
            ];

            data.forEach(item => {
                addRow(item);
            });
            
            function addRow(data) {
                const table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
                const newRow = table.insertRow(table.rows.length);

                const selectBox = newRow.insertCell(0);            
                const slBox = document.createElement('INPUT');
                slBox.setAttribute("type", "checkbox");
                slBox.className = "selectBoxList";
                slBox.setID = "selectlist";
                selectBox.appendChild(slBox);

                const pd = newRow.insertCell(1);
                const divPd = document.createElement('DIV')
                const t1 = document.createTextNode(data.product);
                divPd.appendChild(t1);
                pd.appendChild(divPd);

                const detailButton = newRow.insertCell(2);
                const deBut = document.createElement('BUTTON');
                const t2 = document.createTextNode("See More");
                deBut.appendChild(t2);
                deBut.className = "seeDetail";
                deBut.addEventListener("click", linkToDetail);
                detailButton.appendChild(deBut);

                const ev = newRow.insertCell(3);
                const divEv = document.createElement('DIV')
                const t3 = document.createTextNode(data.embroideryV);
                divEv.appendChild(t3);
                divEv.style = "text-align: center;"
                ev.appendChild(divEv);

                const eid = newRow.insertCell(4);
                const divEid = document.createElement('DIV')
                const t4 = document.createTextNode(data.embroideryID);
                divEid.appendChild(t4);
                divEid.style = "text-align: center;"
                eid.appendChild(divEid);
            }

            function linkToDetail() {
                window.location.href='Embroidery_detail.php'
            }
        });
    </script>
</head>
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
        <button class="addDetail" onclick="window.location.href='Embroidery_detail.php'">Add Detail for Selected</button>
    </div>

    <table style="width: 100%;" id="dataTable">
        <thead>
        <tr style="border-bottom:2px solid black; font-size: 24px; height: 30px;">
            <th style="width: 10%;">Select</th>
            <th style="width: 50%; text-align: left;">Product Name</th>
            <th style="width: 10%;"></th>
            <th style="width: 15%;">Embroidery Value</th>
            <th style="width: 15%;">EmbroideryID</th>
        </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    <div class="bottom_line">
        <button type="button" class="buttonStyle" style = "margin-left: 5%" onclick="window.location.href='3_Bill_desktop.php'">
            <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
            <div>Return</div>
        </button>
        <button type="button" class="buttonStyle" style = "margin-left: 65%" onclick="window.location.href='3_Bill_desktop.php'">
            <div>Complete</div>
            <div><img src="icon _arrow right 1_.png" style="width: 25px;"></div>
        </button>
     </div>
</body>
</html>