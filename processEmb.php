<?php
include("connection.php");

if (isset($_POST['input'])) {
  $input = $_POST['input'];
  $query = "SELECT * FROM price WHERE product_id LIKE '%$input%'";
  $result = mysqli_query($conn, $query);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      // $data[] = [
      //   "name" => $row['name'],
      //   "type" => $row['type'],
      //   "price" => $row['price'],
      // ];
      $name = $row['name'];
      $type = $row['type'];
      $price = $row['price'];
    }
  }
    echo $name;
}

?>
