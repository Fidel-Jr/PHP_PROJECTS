<?php 

  require("user_validator.php");
  $created = false;
  if(isset($_POST["submit"])){
    $user = new User($_POST);
    $errors = $user->validateForm();
    if(empty($errors)){
      $host = "localhost";
      $user = "root";
      $password = "";
      $dbname = "todo";

      $dsn = "mysql:host=$host;dbname=$dbname";
      $con = new PDO($dsn, $user, $password);

      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $username = $_POST["username"];
      $password = $_POST["password"];
      $gender = $_POST["gender"];
      $age = $_POST["age"];

      if(isset($_FILES["profile"]["name"]) && !empty($_FILES["profile"]["name"])){

       $img_name = $_FILES["profile"]["name"];
       $img_size = $_FILES["profile"]["size"];
       $tmp_name = $_FILES["profile"]["tmp_name"];
       $error = $_FILES["profile"]["error"];
       
       if($error===0){
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_to_lwr = strtolower($img_ex);
        $allowed_exs = array("jpg","jpeg", "png");
        if(in_array($img_ex_to_lwr, $allowed_exs)){
          $new_img_name = uniqid($username,true).'.' .$img_ex_to_lwr;
          $img_upload_path = "profiles/".$new_img_name;
          move_uploaded_file($tmp_name, $img_upload_path);
          $hash = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO user(firstname,lastname,username,password,gender,age,profile_picture) VALUES(?,?,?,?,?,?,?)";
          $pst = $con->prepare($sql);
          $pst->execute([$firstname,$lastname,$username,$hash,$gender,$age,$new_img_name]);
          $created = true;
        } else {
          $er = "You can't upload files of this type!";
        }
       } else {
        $er = "unknown error occurred!";
       }

      } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(firstname,lastname,username,password,gender,age) VALUES(?,?,?,?,?,?)";
        $pst = $con->prepare($sql);
        $pst->execute([$firstname,$lastname,$username,$hash,$gender,$age]);
        $created = true;
      }

      
    }
  }
  

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="bootstrap.bundle.min.js"></script>
    <style>
      .error{
        color: red;
      }
      a{
        text-decoration: none;
      }
      
      #to-span{
        color: rgb(255, 197, 105); 
        font-size: 23px; 
        font-weight: bolder;
      }
      #do-span{
        color: rgb(55, 125, 153);
        font-size: 23px; 
        font-weight: bolder;
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

     <div class="container-fluid shadow-lg p-3 mb-3 mt-1 bg-white rounded" style="max-width: 550px; padding: 10px;">
     <?php 
        if($created==true){
          echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>Account Successfully Created!</strong>
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        }
      ?> 
     <div class="row">
        <div class="col" style="margin-left: 2px;">
        <a class="navbar-brand" href="#" style="margin-top: 5px;"><span id="to-span">To</span> <span id="do-span">Do</span></a>
        <h3 class="mt-2" style="font-weight: bold;">Sign up</h3>
      </div>
      </div>
      <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
          <label for="inputEmail4" class="form-label">Firstname</label>
          <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($_POST["firstname"] ?? "")?>">
          <div class="error">
            <?php echo $errors["firstname"] ?? "" ?>
          </div>
        </div>
        <div class="col-md-6">
          <label for="inputPassword4" class="form-label">Lastname</label>
          <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($_POST["lastname"] ?? "")?>"  id="inputPassword4">
          <div class="error">
            <?php echo $errors["lastname"] ?? "" ?>
          </div>
        </div>
        <div class="col-12">
          <label for="inputAddress" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($_POST["username"] ?? "")?>" id="inputAddress">
          <div class="error">
            <?php echo $errors["username"] ?? "" ?>
          </div>
        </div>
        <div class="col-12">
          <label for="inputAddress2" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($_POST["password"] ?? "")?>" id="inputAddress2">
          <div class="error">
            <?php echo $errors["password"] ?? "" ?>
          </div>
        </div>
        
        <div class="col-md-6">
          <label for="inputState" class="form-label">Gender</label>
          <select id="inputState" class="form-select" name="gender">
            <option>Female</option>
            <option>Male</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="inputZip" class="form-label">Age</label>
          <input type="text" class="form-control" name="age"  id="inputZip" value="<?php echo htmlspecialchars($_POST["age"] ?? "")?>">
          <div class="error">
            <?php echo $errors["age"] ?? "" ?>
          </div>
        </div>
        <div class="col-12">
          <input type="file" name="profile" class="form-control">
        </div>

        
        <div class="modal fade" id="signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Account Created</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Account Successfully Created!
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go back</button>
                <a href="/forms.html/login.html">
                  <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Sign In</button>
                </a>
              </div>
            </div>
          </div>
        </div>
          <div class="col-12">
            <input type="submit" name="submit" value="Sign In" class="btn btn-primary mx-auto d-block mb-2 data-bs-toggle="modal data-bs-target="#signup" role="button" style="padding: 8px 195px 8px 195px; border-radius: 15px;">
            
          </div>
        <div class="col-12 text-secondary">
          <p> Already have an account? <span class="text-primary"><a href="login.php">Log In</a></span></p>
        </div>
      </form>
     </div>
</body>
</html>