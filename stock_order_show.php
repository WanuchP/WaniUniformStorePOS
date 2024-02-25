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
      if($row["instock_qty"]>$row["reorder_point"]){
        $row["status"]="No Need To Order";
      }
      if($row["status"]=="Need To Order"){
        $dropdown = "<select><option>"+.$row["status"].+"</option></select>";
        echo "<tr>
        <td>".$row["product_id"] ."</td>
        <td>".$row["instock_qty"]."</td>
        <td>".$row["reorder_point"]."</td>
        <td>".$row["lead_time"]."</td>
        <td>".$dropdown
        ."</td>
        </tr>";
      }
      else if($row["status"]=="Ordered"){
        $dropdown = 
        "<select>
        <option>"+.$row["status"].+"</option>
        <option>"+.$row["status"].+"</option>
        </select>";
        echo "<tr>
        <td>".$row["product_id"] ."</td>
        <td>".$row["instock_qty"]."</td>
        <td>".$row["reorder_point"]."</td>
        <td>".$row["lead_time"]."</td>
        <td>".$dropdown
        ."</td>
        </tr>";
      }
    }
    echo "</table>";
  }
  else{
    echo "0 result";
  }

  $conn->close();
?>