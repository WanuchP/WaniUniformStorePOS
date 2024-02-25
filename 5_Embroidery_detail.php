<?php
require "connection.php";
if (isset($_GET['embroideryID'])) {
  $embroideryID = $_GET['embroideryID'];
} else {
   $embroideryID = "Embroidery ID not found in URL";
}
?>
<!DOCTYPE html>
<html>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inria+Sans&display=swap');
      </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Embroidery detail desktop</title>
    <link rel="stylesheet" href="styles_emb_detail.css">
</head>
<body style="background-color:#F2F2F2;">
    <div class="user-container">
        <div style="margin-top: auto;"> User: cashier1</div>
    </div>
        <div class="embroidery-details" >Embroidery details</div>
        <div class="student-shirt"> EmbroideryID is : <?php echo $embroideryID; ?></div>
        <div class="instruction">Blank is do not embroidery</div>
    <form method="post">
       <input type="text" class= "inform" name= "detail">
        
        <div class="bottom_line">
        <button type="button" class="button1" onclick="window.location.href='4_embroidery_desktop.php'">
        <div><img src="icon _arrow left 1_.png" style="width: 25px;"></div>
        <div>Return</div>
        </button>
        <button   button type="submit" name="submit" class="button3" >
        <div>Upload</div>
        <div><img src="icon _arrow right 1_.png" style="width: 25px;"></div>
        </button>
        <button   button type="button" class="button2" onclick="window.location.href='embroidery_desktop.php'">
        <div>Complete</div>
        <div><img src="icon _arrow right 1_.png" style="width: 25px;"></div>
        </button>
        </div>
    </form>
    
    <?php
        include "connection.php";
        if(isset($_POST['submit'])){
            $detail = $_REQUEST('detail');

            

        }
    ?>
  



</body>
</html>