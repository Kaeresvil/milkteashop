<?php
session_set_cookie_params(0);
session_start();
//if there is no users log in it cant enter directly to home page
if( $_SESSION['status'] != "user"){
  header('location: admin.php');
}
if( empty ($_SESSION['none'])){
  header('location: login.php');
}


$con = mysqli_connect('localhost:1433','root','12345');
mysqli_select_db($con,'milkteashop');
 //fetch products
 $sql = "SELECT * FROM products";
 $result =  mysqli_query($con, $sql);

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


    <title>Milktea</title>
</head>
<body>


<nav>
<div class="logo">
                <h3>User Dashboard</h3>
               
                </div>	
                <form action="logout.php" method="POST">

                   <button type="submit" class="fas fa-power-off"><p> Log-out</p></button> 
                 
               </form>
               <p style="margin-left: 15px;" >Welcome: <?php echo $_SESSION['name'] ?></p>
</nav>

<header class="bg-dark py-5">
  <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
          <h1 class="display-4 fw-bolder text-white">MILKTEA SHOP</h1>
          <p class="lead fw-normal text-white-50 mb-0"> A refreshing flavored iced tea with tapioca balls at the bottom</p>
      </div>
  </div>
</header>

<section class="py-5">
  <div class="container px-4 px-lg-5 mt-5">
      <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

      <?php
 if ($result->num_rows > 0) {
     ?>

<?php  while($row = $result->fetch_assoc()) {?>
          <div class="col mb-5">
              <div class="card h-100">
                  <!-- Product image-->
                  <img class="card-img-top" src="milktea.jpg" alt="..." />
                  <!-- Product details-->
                  <div class="card-body p-4">
                      <div class="text-center">
                          <!-- Product name-->
                          <h5 class="fw-bolder text-dark"><?php echo $row['name']?></h5>
                          <!-- Product price-->
                          <span style="display: block"class="text-muted">Quantity: <?php echo $row['quantity']?> </span>
                          <span class="text-muted ">Price: <?php echo $row['price']?></span>
                      </div>
                  </div>
                  <!-- Product actions-->
                  <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                      <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Buy Now</a></div>
                  </div>
              </div>
          </div>
          <?php }?>
  <?php }?>   

      </div>
  </div>
</section>
<!-- Footer-->
<footer class="py-5 bg-dark">
  <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Milktea Shop 2022</p></div>
</footer>
    
</div>
</body>
</html>
