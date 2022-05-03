<?php 
// session_set_cookie_params(0);
session_start();
if($num == 0){
echo"<script>alert('Username or Password Incorrect!')</script>";}
 if(empty($_SESSION['none'])){
     header('location: login.php');
 }

session_destroy(); 
header('location:login.php');

?>