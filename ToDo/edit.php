<?php 
  
    session_start();
    $id = $_GET['id'];
    require("manageToDo.php");
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    
    
    require_once('db.php');
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $query = "SELECT * FROM list WHERE id = ?";
    $pst = $con->prepare($query);
    $pst->execute([$_GET['id']]);
    $lists = $pst->fetchAll();
    foreach($lists as $list){

    }
    if(isset($_POST['save'])){
      $list = new TodoList($_POST);
      $updatedList = $list->update($id);
      if($updatedList=="SUCCESS"){
        header("Location: main.php?msg=List Successfully Change");
      } else {
        header("Location: manageTasks.php?msg=Please input all fields");
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
        body{
            background-color: whitesmoke;
            box-sizing: border-box;
        }
        button a{
          color: white;
        }
        a{
          color: gray;
          text-decoration: none;
        }
        a:hover{
          color: dimgray;
        }
        .con1{
          display: flex;
        }
        .col1{
          margin-top: 8px;
        }
        .row2 .col1{
          height: 30px; 
          margin-top: 20px; 
          margin-left: 15px;
        }
        .addBtn{
          margin-left: 4px; 
          border-radius: 15px; 
          padding: 5px 25px;
        }
        .fail{
          color: red;
        }
        .added{
          color: green;
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light">
        <div class="container-fluid">
          <img class="" src="/images/todoIcon.png" alt="" width="35px" style="margin-right: 5px;">
          <a class="navbar-brand" href="#"><span id="to-span" style="color: rgb(255, 197, 105); font-size: 23px; font-weight: bolder;">To</span> <span id="do-span" style="color: rgb(55, 125, 153);font-size: 23px; font-weight: bolder;">Do</span></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-warning" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  To Do 
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item text-danger" href="/main/add_task.html">Add Task</a></li>
                  <li><a class="dropdown-item" href="manageTasks.php">My To Do List</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="/nav_content/completed_task.html">Completed Tasks</a></li>
                  <li><a class="dropdown-item" href="/nav_content/pending_task.html">Pending Tasks</a></li>
                </ul>
              </li>
              <li>
                <a href="/nav_content/today.html">
                  <div class="row rowHvr">
                    <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                      <img src="/images/only-today.png" alt="" width="24" height="24">
                      <p class="text-secondary" style="margin-left: 5px;">Today</p>
                      <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;">2</span>
                    </div>
                  </div>
                </a>
                
              </li>
              <li>
                <a href="/nav_content/tomorrow.html">
                  <div class="row rowHvr">
                    <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                      <img src="/images/tomorrow.png" alt="" width="24" height="24">
                      <p class="text-secondary" style="margin-left: 5px;">Tomorrow</p>
                      <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;">4</span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="/nav_content/next_week.html">
                  <div class="row rowHvr">
                    <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                      <img src="/images/next-week.png" alt="" width="24" height="24">
                      <p class="text-secondary" style="margin-left: 5px;">Next Week</p>
                      <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;">3</span>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
            
            <a href="#top">
              <div class="d-flex" style="margin-right: 20px; color: black;">
                <img src="/images/images.jpeg" alt="" width="45" height="45" style="border-radius: 50%;">
                <p class="" style="margin-top: 12px; margin-left: 5px; font-weight: bold;"><?php echo $firstname. " " . $lastname ?></p>
              </div>
            </a> 

            <div class="d-flex">
              <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
                <a href="login.php">
                  <span>Log Out</span>
                <input type="submit" name="logout" value="Log Out" class="text-secondary" style="opacity: 0; margin-top: -5px;"> 
                </a>
              </form>
              
            </div>
          </div>
        </div>
      </nav>
     
        <!-- MAIN-CONTENT -->
      <div class="con2 container mt-4" id="top">
        <div class="col d-flex">
            <div class="row">
              <div class="row">
                <div class="col d-flex mb-3">
                  <img src="/images/images.jpeg" alt="" width="50" height="50" style="border-radius: 50%;">
                  <p class="" style="margin-top: 12px; margin-left: 5px; font-weight: bold;"><?php echo $firstname. " " . $lastname ?> <span style="font-size: 12px;"> <a href="/main/manage.html">My Tasks</a></span></p>
                </div>
              </div>
              <form action="" method="post" class="row g-2">
                <div class="row"> 
                  <div class="mb-3">
                    <label for="" style="color: rgb(55, 125, 153); margin-left: 4px;">Title</label>
                    <input class="form-control mb-2" type="text" name="title" value="<?php echo htmlspecialchars($list["title"] ?? "") ?>" style="border-radius: 15px; padding: 8px 10px;" placeholder="Title">
                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label" style="color: rgb(55, 125, 153);margin-left: 4px;">Category</label>
                    <input class="form-control mb-2" type="text" name="category" value="<?php echo htmlspecialchars($list["category"] ?? "") ?>" style="border-radius: 15px; padding: 8px 10px;" placeholder="Category">
                    
                  </div>
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label" style="color: rgb(55, 125, 153);margin-left: 4px;">Date</label>
                    <input class="form-control" type="date" name="date" value="<?php echo htmlspecialchars($list["date"] ?? "") ?>" style="border-radius: 15px;padding: 8px 8px;" placeholder="Due Date">
                    
                  </div>
                </div>
              
              <div class="col-md-4 mt-2 mb-3">
                <button type="submit" name="save" class="addBtn btn btn-primary mt -2" data-bs-toggle="modal" data-bs-target="#">Save</button>
                <button type="submit" name="save" class="addBtn btn btn-danger mt -2" data-bs-toggle="modal" data-bs-target="#"><a href="manageTasks.php?msg=Cancelled">Cancel</a></button>
                

                
              </div>
              </form>
            </div>
            <div class="col mt-2 d-none d-md-block">
              <img src="/images/done2.png" alt="">
            </div>
        </div>
        </div>
</body>
</html>

<?php

  if(isset($_POST["logout"])){
    session_destroy();
  }

?>