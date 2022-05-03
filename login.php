<?php include_once "header.php";

session_start();


$con = mysqli_connect('localhost:1433','root','12345');
mysqli_select_db($con,'milkteashop');

if(isset($_POST['g-recaptcha-response'])){
    $secrectkey = "6LcM3b4fAAAAAHtC0sYZcOtRlsfkGuIzah_ZmJ8l";//copy the secret key of google reCaptcha 
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url ="https://www.google.com/recaptcha/api/siteverify?secret=$secrectkey&response=$response&remoteip=$ip";
    $fire = file_get_contents($url);
    $data = json_decode($fire);


    if($data->success == true){
        $name= $_POST['username'];
        $pass =$_POST['password'];
        
        
        
        $pass = md5($pass);//encrypte password before store to database(security)
        $s = "SELECT * from users where email = '$name' && password ='$pass'";
        $result = mysqli_query($con, $s);
        
        $num = mysqli_num_rows($result);
        
        if($num == 1){
            while($row=mysqli_fetch_array($result)){
                if($row['status'] == 'admin'){
                $_SESSION['status']=$row['status'];
                header('location:admin.php');
                }else{
                    $_SESSION['status']=$row['status'];
                    $_SESSION['name']=$row['name'];
                    header('location:user.php');
                }
            }
            $_SESSION['none']=$num;
              }else{
               $_SESSION['incorrect'] = 1;
             
            }
    }else{
        $_SESSION['recaptcha'] = 1;
    }




}
?>

<body>
    <div class="wrapper">
        <section class="form login">
        <header>MilkTea Shop</header>

        <form action="#" method="POST">
      
      
        <?php if (isset($_SESSION['incorrect']) == 1) { ?>
                    <span style="color:red; font-size: 17px; text-align: center" id="error">No User Found!</span>
                <?php } ?>
  

                <div class="fields input">
                    <label>Username</label>
                    <input type="email" name="username" placeholder="Eneter your email" required >
                 
                </div>
               

                <div class="fields input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
               
                <div class="fields button">
                <div class="g-recaptcha" data-sitekey="6LcM3b4fAAAAAKErlQGhrpfRKBQ2tztxGztmio2x"></div> <!-- copy the site key of google reCaptcha -->
                <?php if (isset($_SESSION['recaptcha']) == 1) { ?>
                    <span style="color:red; font-size: 17px; text-align: center" id="recap">reCAPTCHA required!</span>
                <?php } ?>
                </div>
                <div class="fields button">
                    <input type="submit"  name="login" id="btn" value="Login">
                </div>
        </form>
       
    </section>

    </div>
<!-- 
    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/login.js"></script> -->
    <script>
         $(document).ready(function(e) {   
            setTimeout(function() {
        $("#error").hide();
        $("#errorusername").hide();
        $("#recap").hide();
    }, 3000);
    console.log("Hello")
 });

   
</script>

</body>


</html>