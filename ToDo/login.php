<?php 

  session_start();
  require_once 'manageToDo.php';
  $found = true;
  if(isset($_POST["submit"])){
    
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "todo";
    $dsn = "mysql:host=$host;dbname=$dbname";
    $con = new PDO($dsn, $user, $password);
    // $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $password = null;
    $sql = "SELECT * FROM user WHERE username = ?";
    $pst = $con->prepare($sql);
    $result = $pst->execute([$_POST["username"]]);
    $user = $pst->fetch(PDO::FETCH_ASSOC);
    if($pst->rowCount()>0){
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["firstname"] = $user["firstname"];
      $_SESSION["lastname"] = $user["lastname"];
      $_SESSION["username"] = $user["username"];
      $_SESSION["profile_pic"] = $user["profile_picture"];
      $password = $user["password"];
    }
    if($pst->rowCount()>0 && password_verify($_POST["password"],$password)){
      header("Location: main.php");
    } else {
      $found = false;
    }

  }
 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="bootstrap.bundle.min.js"></script>
    <style>
      .error{
        color: red;
      }
    </style>
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

      <div class="container-fluid mt-5 shadow p-3 " style="width: 370px; padding: 10px;">
        <div class="row">
          <div class="col" style="margin-left: 2px;">
            <a class="navbar-brand" href="#" style="margin-top: 5px;"><span style="color: rgb(255, 197, 105); font-size: 23px; font-weight: bolder;">To</span> <span style="color: rgb(55, 125, 153);font-size: 23px; font-weight: bolder;">Do</span></a>
            <h3 class="mt-2" style="font-weight: bold;">Sign in</h3>
           </div>
        </div>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" class="row g-3 mt-3 mx-auto d-block">
          <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="inputEmail4">
            <label for="inputPassword4" class="form-label mt-4">Password</label>
            <input type="password" class="form-control mb-5" name="password" id="inputPassword4"> 
            <div class="error">
            <?php 
              if(!$found){
                echo "User not found!";
              }
            ?> 
            </div>
          </div>
          
          
            <div class="col-12">
              <input type="submit" name="submit" value="Sign In" class="btn btn-primary mx-auto d-block mb-4"  data-bs-toggle="modal" data-bs-target="#" role="button" style="padding: 8px 135px 8px 135px; border-radius: 15px;">
            </div>
          
          <div class="col-12 text-secondary">
            <p>Don't have an account yet? <span class="text-primary"><a href="register.php">Register</a></span></p>
          </div>
        </form>
    </div>
</body>
</html>