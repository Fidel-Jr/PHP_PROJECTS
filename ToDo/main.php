<?php 

    session_start();
    if(isset($_SESSION["user_id"])) {
    require("manageToDo.php");
    require 'db.php';
    include 'User.php';
    $user = getUser($_SESSION["user_id"],$con);
    
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    $profile_pic = $_SESSION["profile_pic"];
    $isAdded = false;
    $errorMessage = "";
    $successMessage = "";
    $newList = null;
    if(isset($_POST["add"])){
      $newList = new TodoList($_POST);
      $list = $newList->add();
      if(array_key_exists("title",$list) && array_key_exists("category",$list) && array_key_exists("date",$list)){
        $isAdded = true;
        $successMessage = "New Task Added!";
      } else {
        $errorMessage = "All fields are required!";
      }
    }

    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    $query = "SELECT id, title, category, date, status FROM list WHERE user_id = ?";
    $pst = $con->prepare($query);
    $pst->execute([$_SESSION["user_id"]]);
    $lists = $pst->fetchAll();

    // TODAY'S TASKS COUNT
    $date = new DateTime();
    $today = $date->format("Y-m-d");
    $query = "SELECT id, title, category, date, status FROM list WHERE user_id = ? AND date = ?";
    $pst = $con->prepare($query);
    $pst->execute([$_SESSION["user_id"],$today]);
    $todayLists = $pst->fetchAll();
    $todays_task_count = count($todayLists);
    $_SESSION["todays_task_count"] = $todays_task_count;

    // TOMORROW'S TASKS COUNT
    $dateToday = new DateTime();
    $today = $dateToday->format("Y-m-d");
    $dateTom = new DateTime('tomorrow');
    
    $tomorrow = $dateTom->format("Y-m-d");
    $query = "SELECT id, title, category, date, status FROM list WHERE user_id = ? AND date = ? AND date > ?";
    $pst = $con->prepare($query);
    $pst->execute([$_SESSION["user_id"],$tomorrow, $today]);
    $tomorrowLists = $pst->fetchAll();
    $tomorrows_task_count = count($tomorrowLists);
    $_SESSION["tomorrows_task_count"] = $tomorrows_task_count;

    // NEXT WEEK'S TASKS COUNT
    $dateToday = new DateTime();
    $today = $dateToday->format("Y-m-d");
    $dateNextWeek = clone $dateToday;
    $dateNextWeek->modify('next week');
    $nextWeek = $dateNextWeek->format("Y-m-d");
    $query = "SELECT id, title, category, date, status FROM list WHERE user_id = ? AND date = ? AND date > ? AND date > ?";
    $pst = $con->prepare($query);
    $pst->execute([$_SESSION["user_id"],$nextWeek, $today, $tomorrow]);
    $nextweekLists = $pst->fetchAll();
    $nextWeek_task_count = count($nextweekLists);
    $_SESSION["nextWeek_task_count"] = $nextWeek_task_count;



  if(isset($_POST["logout"])){
    session_destroy();
    $newList->closeConnection();
    header("Location: login.php?msg=Logged Out");
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
        a{
          color: gray;
          text-decoration: none;
        }
        .rowHvr p{
          margin-left: 5px;
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
          <img class="" src="images/todoIcon.png" alt="" width="35px" style="margin-right: 5px;">
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
                <li><a class="dropdown-item text-danger" href="main.php">Home</a></li>
                <li><a class="dropdown-item text-dark" href="manageTasks.php">My To Do List</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-dark" href="completedTasks.php">Completed Tasks</a></li>
                <li><a class="dropdown-item text-dark" href="pendingTasks.php">Pending Tasks</a></li>
                <li><a class="dropdown-item text-dark" href="updateUser.php">Edit Profile</a></li>
                </ul>
              </li>
              <li>
                <a href="todayTasks.php">
                  <div class="row rowHvr">
                    <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                      <img src="images/only-today.png" alt="" width="24" height="24">
                      <p class="text-secondary">Today</p>
                      <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $todays_task_count ?></span>
                    </div>
                  </div>
                </a>
                
              </li>
              <li>
                <a href="tomorrowTasks.php">
                  <div class="row rowHvr">
                    <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                      <img src="images/tomorrow.png" alt="" width="24" height="24">
                      <p class="text-secondary">Tomorrow</p>
                      <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $tomorrows_task_count ?></span>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a href="nextWeekTasks.php">
                  <div class="row rowHvr">
                    <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                      <img src="images/next-week.png" alt="" width="24" height="24">
                      <p class="text-secondary">Next Week</p>
                      <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $nextWeek_task_count ?></span>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
            
            <a href="#top">
              <div class="d-flex" style="margin-right: 20px; color: black;">
                 <img src="profiles/<?= $user["profile_picture"]  ?>" alt="" width="55" height="55" style="border-radius: 50%;">
                <p class="" style="margin-top: 12px; margin-left: 5px; font-weight: bold;"><?php echo $firstname. " " . $lastname ?></p>
              </div>
            </a> 

            <div class="d-flex">
              <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
                <a href="">
                <input type="submit" name="logout" value="Log Out" class="text-secondary" style="border: none; background-color: whitesmoke;"> 
                </a>
              </form>
              
            </div>
          </div>
        </div>
      </nav>
     
        <!-- MAIN-CONTENT -->
        <?php 
          if($user){

          
        ?>
      <div class="con2 container mt-4" id="top">
        <div class="col d-flex">
            <div class="row">
              <div class="row">
                <div class="col d-flex mb-3">
                  <img src="profiles/<?=$user["profile_picture"] ?>" alt="" width="50" height="50" style="border-radius: 50%;">
                  <p class="" style="margin-top: 12px; margin-left: 5px; font-weight: bold;"><?php echo $firstname. " " . $lastname ?> <span style="font-size: 12px;"> <a href="manageTasks.php">My Tasks</a></span></p>
                </div>
              </div>
              <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" class="row g-2">
                <div class="row"> 
                  <div class="mb-3">
                    <?php 

                      if(!empty($errorMessage)){
                        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong> $errorMessage </strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                      }
                    
                    ?>
                    <label for="" style="color: rgb(55, 125, 153); margin-left: 4px;">Add New Task</label>
                    <input class="form-control mb-2" type="text" name="title" value="<?php echo htmlspecialchars($_POST["title"] ?? "") ?>" style="border-radius: 15px; padding: 8px 10px;" placeholder="Title">
                    <div class="fail">
                    <?php
                        echo $list["e_title"] ?? '';
                      ?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label" style="color: rgb(55, 125, 153);margin-left: 4px;">Category</label>
                    <input class="form-control mb-2" type="text" name="category" value="<?php echo htmlspecialchars($_POST["category"] ?? "") ?>" style="border-radius: 15px; padding: 8px 10px;" placeholder="Category">
                    <div class="fail">
                      <?php
                        echo $list["e_category"] ?? '';
                      ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label" style="color: rgb(55, 125, 153);margin-left: 4px;">Date</label>
                    <input class="form-control" type="date" name="date" value="<?php echo htmlspecialchars($_POST["date"] ?? "") ?>" style="border-radius: 15px;padding: 8px 8px;" placeholder="Due Date">
                    <div class="fail">
                    <?php
                        echo $list["e_date"] ?? '';
                      ?>
                    </div>
                  </div>
                </div>
              
              <div class="col-md-4 mt-2 mb-3">
                <input type="submit" value="Add" name="add" class="addBtn btn btn-primary mt -2" data-bs-toggle="modal" data-bs-target="#">
                <div class="added mt-2">
                  <?php 
                    if(!empty($successMessage)){
                      echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong> $successMessage </strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                    }
                  ?>
                </div>
              </div>
              </form>
            </div>
            <div class="col mt-2 d-none d-md-block">
              <img src="images/done2.png" alt="">
            </div>
        </div>
        <table class="table table-striped table-hover table-responsive-sm" style="margin-left: 12px;">
            <thead>
              <tr class="bg-dark text-white">
                <th scope="col">#</th>
                <th scope="col">Task</th>
                <th scope="col">Category</th>
                <th scope="col">Due</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              
              <tr>
                <?php 
                  $status = "";
                  $task_number = 0;
                  foreach($lists as $list){
                    $task_number += 1;
                    $time = new DateTime($list['date']);
                    $formattedDate = $time->format('Y-m-d');
                    
                    $today = new DateTime();
                    $formattedToday = $today->format('Y-m-d');
                    
                    if($formattedDate > $formattedToday){
                      $status = "Pending";
                    } elseif($formattedDate < $formattedToday) {
                      $status = "Overdue";
                    }else {
                      $status = "Pending";
                    }
                  
                ?>
                
                      <td><?php echo $task_number ?></td>
                      <td><?php echo $list["title"] ?></td>
                      <td><?php echo $list["category"] ?></td>
                      <td><?php echo $list["date"] ?></td>
                      <td><?php echo $status ?></td>
                      </tr>
                <?php 
                  }
                ?>
              
            
            </tbody>
            </table>
        </div>
        <?php
        
          } else {

          }
        
        ?>
</body>
</html>
<?php 
        }else {
          header("Location: login.php");
        }
      
?>
