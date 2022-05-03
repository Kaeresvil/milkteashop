<?php
session_set_cookie_params(0);
session_start();
//if there is no users log in it cant enter directly to home page
 if( $_SESSION['status'] != "admin"){
    header('location: user.php');
 }
 if( empty ($_SESSION['none'])){
    header('location: login.php');
 }

 $con = mysqli_connect('localhost:1433','root','12345');
 mysqli_select_db($con,'milkteashop');

 //add new product
 if(isset($_POST['addproduct'])){
 $name = $_POST['name'];
 $price =$_POST['price'];
 $qnty =$_POST['qnty'];
 


 $reg = "INSERT into products (name, price, quantity) values('$name','$price','$qnty')";
 mysqli_query($con, $reg);
 

 }
 //add new user
 if(isset($_POST['adduser'])){
 $name = $_POST['name'];
 $email =$_POST['email'];
 $pass =$_POST['password'];
 $role =$_POST['role'];
 

 $pass = md5($pass);//emcrypte password before store to database(security)
 $s = "SELECT * from users where email = '$email'";
 $result = mysqli_query($con, $s);
 
 $num = mysqli_num_rows($result);
 if($num == 1){
     echo "<div class='message warning'>Username Existed</div>";
 }else{
     $reg = "INSERT into users (name,email, password,status) values('$name','$email','$pass','$role')";
     mysqli_query($con, $reg);

 }
 

 }
 //fetch products
 $sql = "SELECT * FROM products";
 $result =  mysqli_query($con, $sql);
//fetch users
 $sql1 = "SELECT * FROM users";
 $users =  mysqli_query($con, $sql1);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="layout.css">
    <script src="https://kit.fontawesome.com/6d9aac6a0d.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Milktea</title>
</head>
<body>


<nav>
<div class="logo">
                <h3>Admin Dashboard</h3>
                </div>	
                <form action="logout.php" method="POST">

                   <button type="submit" class="fas fa-power-off"><p> Log-out</p></button> 
                
               </form>

</nav>

<header class="bg-dark py-5">
  <div class="container px-0 px-lg-0 my-0">
      <div class="text-center text-white">
          <h1 class="display-4 fw-bolder text-white">MILKTEA SHOP</h1>
          <p class="lead fw-normal text-white-50 mb-0"> A refreshing flavored iced tea with tapioca balls at the bottom</p>
      </div>
  </div>
</header>
<div class="row">
  <div class="column">
     <h2 style="color: black; text-align: center">Milktea Products</h2>
      <button type="button" class="btn btn-success my-3 mx-3" data-toggle="modal" data-target="#addproduct">
      Add new Product
</button>
<?php
 if ($result->num_rows > 0) {
     ?>
    <table>
      <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
      </tr>
      <?php  while($row = $result->fetch_assoc()) {?>
      <tr>
        <td><?php echo $row['name']?></td>
        <td><?php echo $row['price']?></td>
        <td><?php echo $row['quantity']?></td>
      </tr>
      <?php }?>
    </table>
    <?php }?>
  </div>


  <div class="column">
  <h2 style="color: black; text-align: center">Master List of User</h2>
  <button type="button" class="btn btn-success my-3 mx-3" data-toggle="modal" data-target="#adduser">
      Add new User
</button>
    <?php
 if ($users->num_rows > 0) {
     ?>
    <table>
      <tr>
        <th>Name</th>
        <th>Username</th>
        <th>Role</th>
      </tr>
      <?php  while($row = $users->fetch_assoc()) {?>
      <tr>
        <td><?php echo $row['name']?></td>
        <td><?php echo $row['email']?></td>
        <td><?php echo $row['status']?></td>
      </tr>
      <?php }?>
    </table>
    <?php }?>
  </div>
</div>


<!-- Modal add new Product -->
<div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color: black;" id="exampleModalLabel">Add new Product</h5>
      </div>
      <div class="modal-body">
      <form role="form" method="POST" action="">
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label style="color:black;" class="control-label">Product Name</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="name" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color:black;" class="control-label">Price</label>
                        <div>
                            <input type="number" class="form-control input-lg" name="price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color:black;" class="control-label">Quantity</label>
                        <div>
                            <input type="number" min="1" class="form-control input-lg" name="qnty">
                        </div>
                    </div>
                
                  
               
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="addproduct" class="btn btn-primary">Add Product</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal add new User -->
<div class="modal fade" id="adduser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color: black;" id="exampleModalLabel">Add new User</h5>
      </div>
      <div class="modal-body">
      <form role="form" method="POST" action="">
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label style="color:black;" class="control-label">Name</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="name" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color:black;" class="control-label">Username</label>
                        <div>
                            <input type="email" class="form-control input-lg" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color:black;" class="control-label">Password</label>
                        <div>
                            <input type="password" min="1" class="form-control input-lg" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <input type="hidden" class="form-control input-lg" name="role" value="user">
                        </div>
                    </div>
                
                  
               
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="adduser" class="btn btn-primary">Add User</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Footer-->
<!-- <footer class="py-5 bg-dark">
  <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Milktea Shop 2022</p></div>
</footer> -->
    
</div>
</body>

<style>
* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
  border-right: 1px solid black;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  color: black;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
</html>
