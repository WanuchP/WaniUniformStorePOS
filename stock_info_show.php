<?php
  $sname= "127.0.0.1";
  $uname= "t66g1";
  $password = "t66g1";
  $db_name = "t66g1";
  $conn = mysqli_connect($sname, $uname, $password, $db_name);
  if (!$conn) {
      echo "Connection failed!";
  }
  $sql = "SELECT * FROM recieved order by recieved_id DESC;";
  $result = $conn-> query($sql);
  if ($result-> num_rows > 0){
    while ($row = $result->fetch_assoc()){
      echo "<tr><td>".
            $row["recieved_id"] ."</td><td>".
            $row["product_id"]."</td><td>".
            $row["date"]."</td><td>".
            $row["cost_unit"]."</td><td>".
            $row["qty"]."</td><td>".
            "</td></tr>";
    }
    echo "</table>";
  }
  else{
    echo "0 result";
  }

  $conn->close();
?>