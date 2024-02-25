<?php 
session_start(); 
include "connection.php";
if (isset($_POST['uname']) && isset($_POST['pword'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }
    $username = validate($_POST['uname']);
    $password = validate($_POST['pword']);
   
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $username && $row['password'] === $password) {
                echo "Logged in!";
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                switch ($_SESSION['id'] ){
                    case "0": //id = 0 -> ceo
                        header("Location: 10_CEO_dektop.php");
                        exit();
                    case "1": //id = 1 -> cashier
                        header("Location: 2_CashierDesktop.php");
                        exit();
                    case "2": //id = 2 -> stock checker
                        header("Location: 7_stockDesktop.php");
                        exit();
                    default:
                        header("Location: index.php?error=Incorect Username or password");
                        exit();
                }
            }else{
                header("Location: index.php?error=Incorect Username or password");
                exit();
            }
        }else{
            header("Location: index.php?error=Incorect Username or password");
            exit();
        }
        
}else{
    header("Location: Login_desktotp.php");
    exit();
}