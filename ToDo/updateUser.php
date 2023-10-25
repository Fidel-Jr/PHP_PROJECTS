<?php 


  session_start();
  if(isset($_SESSION["user_id"])) {
  include "db.php";
  include "User.php";

  $user = getUser($_SESSION["user_id"],$con);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light">
      <div class="container-fluid">
        <img class="" src="/images/todoIcon.png" alt="" width="35px" style="margin-right: 5px;">
        <a class="navbar-brand" href="#"><span style="color: rgb(255, 197, 105); font-size: 23px; font-weight: bolder;">To</span> <span style="color: rgb(55, 125, 153);font-size: 23px; font-weight: bolder;">Do</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/main/home.html" style="color:  rgb(255, 197, 105);">Home</a>
            </li>
          </ul>
          <div class="d-flex">
            <a class="text-secondary" href="register.php"><p style="margin-right: 25px; margin-top: 10px;">Register</p></a> 
            <a class="text-secondary" href="login.php"><p style="margin-right: 20px; margin-top: 10px;">Log In</p></a>
          </div>
        </div>
      </div>
      </nav>
      
      <?php
        if($user){
          
        
      ?>
      <div class="container-fluid mt-2 shadow p-3 " style="width: 370px; padding: 10px;">
      <?php
      
        if(isset($_GET["error"])){
          $errorMsg = $_GET["error"];
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong> $errorMsg </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        else if(isset($_GET["success"])){
          $successMsg = $_GET["success"];
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong> $successMsg </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }  

      ?>
        <div class="row">
          <div class="col" style="margin-left: 2px;">
            <a class="navbar-brand" href="#" style="margin-top: 5px;"><span style="color: rgb(255, 197, 105); font-size: 23px; font-weight: bolder;">To</span> <span style="color: rgb(55, 125, 153);font-size: 23px; font-weight: bolder;">Do</span></a>
            <h3 class="mt-2" style="font-weight: bold;">Edit Profile</h3>
           </div>
        </div>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data" class="row g-3 mt-3 mx-auto d-block">
          <div class="col-md-12">
            <label for="inputEmail4" class="form-label">New Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo $user["username"] ?>" id="inputEmail4">
            <label for="inputPassword4" class="form-label mt-4">New Password</label>
            <input type="password" class="form-control mb-3" name="password" id="inputPassword4"> 
            
          </div>
          
          <div class="col-12">
            <input type="file" name="profile" class="form-control">
          </div>
          <div class="col d-flex mb-3">
            <img src="profiles/<?= $user["profile_picture"] ?>" alt="" width="50" height="50" style="border-radius: 50%;">
            <input type="text" hidden="hidden" name="old_pp" value="<?= $user["profile_picture"] ?>">
          </div>
          
            <div class="col-12">
              <input type="submit" name="update" value="Update" class="btn btn-primary mx-auto d-block mb-4"  data-bs-toggle="modal" data-bs-target="#" role="button" style="padding: 8px 135px 8px 135px; border-radius: 15px;">
            </div>
          
          <a href="main.php">Go Back</a>
        </form>
    </div>
    <?php
      } else {
        session_destroy();
        header("Location: main.php");
        exit();
      }
    ?>

</body>
</html>
<?php 

    } else {
      header("Location: login.php");
    }

?>