<?php

    session_start();
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    $user_id = $_SESSION["user_id"];
    require_once("db.php");
    require("manageToDo.php");
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $showAll = true;
    
    $dateToday = new DateTime();
    $today = $dateToday->format("Y-m-d");
    $dateTom = new DateTime('tomorrow');
    
    $tomorrow = $dateTom->format("Y-m-d");
    $query = "SELECT id, title, category, date, status FROM list WHERE user_id = ? AND date = ? AND date > ?";
    $pst = $con->prepare($query);
    $pst->execute([$_SESSION["user_id"],$tomorrow, $today]);
    $lists = $pst->fetchAll();
    $count = count($lists);

    $user = new TodoList($_GET);
    $error = "";
    if(isset($_GET["search"]) && empty($_GET["task"])){
      $error = $user->search($_GET["task"],$_SESSION["user_id"]);
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
        a{
            text-decoration: none;
        }
        .con1{
          display: flex;
        }
        .rowHvr p{
          margin-left: 5px;
        }
        .col1{
          margin-top: 8px;
        }
        .sidebar{
          position: sticky;
          border-right: 1px solid rgb(253, 250, 250);
          top: 90px;
        }
        .row2 .col1{
          height: 30px; 
          margin-top: 20px; 
          margin-left: 15px;
        }
        .sidebar .row{
          cursor: pointer;
          padding: 12px 5px;
          padding-bottom: 8px;
        }
        .sidebar .row .col{
          margin-top: 0;
        }
        .sidebar:hover .rowHvr:hover{
          background-color: rgb(216, 214, 214);
        }
        
        .settingHvr{
          padding-top: 10px;
          padding-bottom: 0;
          padding-left: 28px;
        }
        .sidebar .settingHvr:hover{
          background-color: rgb(216, 214, 214);
          
        }
        .sidebar .col p{
          margin-top: 2px; 
          margin-left: 8px;
          font-size: 13px;
        }
        .searchBtn{
          margin-left: 10px; 
          border-radius: 15px; 
          height: fit-content; 
          padding: 6px 15px 6px 15px;
        }
        button a{
          color: white;
        }
    </style>
</head>
<body>
    
  <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light">
    <div class="container-fluid">
      <img class="" src="images/todoIcon.png" alt="" width="35px" style="margin-right: 5px;">
      <a class="navbar-brand" href="#"><span style="color: rgb(255, 197, 105); font-size: 23px; font-weight: bolder;">To</span> <span style="color: rgb(55, 125, 153);font-size: 23px; font-weight: bolder;">Do</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" style="color: #143d59;" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              To Do 
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item text-dark" href="main.php">Home</a></li>
                <li><a class="dropdown-item text-dark" href="manageTasks.php">My To Do List</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-dark" href="completedTasks.php">Completed Tasks</a></li>
                <li><a class="dropdown-item text-dark" href="pendingTasks.php">Pending Tasks</a></li>
            </ul>
          </li>
          <li>
            <a href="todayTasks.php">
              <div class="row rowHvr">
                <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                  <img src="images/only-today.png" alt="" width="24" height="24">
                  <p class="text-secondary">Today</p>
                  <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $_SESSION["todays_task_count"] ?></span>
                </div>
              </div>
            </a>
            
          </li>
          <li>
            <a href="tomorrowTasks.php">
              <div class="row rowHvr">
                <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                  <img src="images/tomorrow.png" alt="" width="24" height="24">
                  <p class="text-danger">Tomorrow</p>
                  <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $_SESSION["tomorrows_task_count"] ?></span>
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
                  <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $_SESSION["nextWeek_task_count"] ?></span>
                </div>
              </div>
            </a>
          </li>
        </ul>
        
        <a href="#top">
          <div class="d-flex" style="margin-right: 20px; color: black;">
            <img src="images/images.jpeg" alt="" width="45" height="45" style="border-radius: 50%;">
            <p class="" style="margin-top: 12px; margin-left: 5px; font-weight: bold;"><?php echo $firstname. " " . $lastname ?></p>
          </div>
        </a> 

        
      </div>
    </div>
  </nav>
  <!-- MAIN-CONTENT -->
      <div class="container con1 mt-4 shadow-lg" id="top">
        
        <div class="con2 container">
          <div class="container-fluid">
            <div class="row">
              <h1 class="text-primary">Tomorrow's Tasks</h1>
                <label class="mb-0" style="margin-left: 6px; color: rgb(55, 125, 153);" for="">Search Task</label>
              <div class="col d-flex">
              <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="get" class="row">
                  <div class="col">
                    <input class="form-control mb-2" type="text" name="task" value="<?php echo htmlspecialchars($_GET["task"] ?? "") ?>" style="border-radius: 15px; width: 700px; padding: 8px 10px;" placeholder="Title"> 
                    <input class="mb-3" type="submit" name="showAll" value="Show All" style="border: none ; color: rgb(55, 125, 153);">
                  </div>
                  <div class="col" style="margin-left: -25px; margin-top: 2px;">
                    <input type="submit" name="search" value="Search" class="searchBtn btn btn-primary">
                    <span style="color: red;"> <?php echo $error["e_search_title"] ?? '';?> </span>
                  </div>
                    
                </form>
            </div> 
              
              
            </div>
            
            <div class="col-md-4 mt-2 mb-3">
              
              <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Do you want to add this task?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <table class="table table-striped table-hover table-responsive" style="margin-left: 12px;">
            <thead>
              <tr class="bg-dark text-white">
                <th scope="col">#</th>
                <th scope="col">Task</th>
                <th scope="col">Category</th>
                <th scope="col">Due</th>
                <th scope="col">Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

            <tr>
              <?php 
                if(isset($_GET["search"])){
                  $title = trim($_GET["task"]);
                  if(!empty($title)){
                    $showAll = false;
                    $query = "SELECT * FROM list WHERE title LIKE ? AND user_id= ? AND date = ?";
                    $pst = $con->prepare($query);
                    $val = "%". $title . "%";
                    $pst->execute([$val,$user_id,$tomorrow]);
                    $search_lists = $pst->fetchAll();
                    $status = "";
                    $task_number = 0;
                    foreach($search_lists as $list){
                        $task_number += 1;
                        $time = new DateTime($list['date']);
                        $formattedDate = $time->format('Y-m-d');
                        
                        $today = new DateTime();
                        $formattedToday = $today->format('Y-m-d');
                        
                        if($formattedDate > $formattedToday){
                          $status = "Pending";
                        } elseif($formattedDate < $formattedToday) {
                          $status = "Overdue";
                        }
                      ?>
                        <td><?php echo $task_number ?></td>
                        <td><?php echo $list["title"] ?></td>
                        <td><?php echo $list["category"] ?></td>
                        <td><?php echo $list["date"] ?></td>
                        <td><?php echo $list["status"] ?? $status ?></td>
                        <td>
                          
                        <button type="button" class="btn btn-primary btn-sm" style="-right: 5px;"> <a href="edit.php?id=<?php echo $list['id']?>">Edit</a></button>
                        <button type="button" name="delete" class="btn btn-danger btn-sm text-white" style="margin-right: 5px;"><a href="delete.php?id=<?php echo $list['id']?>">Delete</a></button>
                        
            </tr>
                      <?php
                      }
                  }
                }
              ?>
                      
              <!-- Will run automatically when search button is not set and when show 
                   all is clicked-->
              <tr>
              <?php 

                if($showAll){
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
                    } else {
                      $status = "Pending";
                    }
                  
              ?>
                      <td><?php echo $task_number ?></td>
                      <td><?php echo $list["title"] ?></td>
                      <td><?php echo $list["category"] ?></td>
                      <td><?php echo $list["date"] ?></td>
                      <td><?php echo $list["status"] ?? $status?></td>
                      <td>
                        
                        <button type="button" class="btn btn-primary btn-sm" style="margin-right: 5px;"> <a href="edit.php?id=<?php echo $list['id']?>">Edit</a></button>
                        <button type="button" name="delete" class="btn btn-danger btn-sm text-white"  style="margin-right: 5px;"><a href="delete.php?id=<?php echo $list['id']?>">Delete</a></button>
                        
                      </td>
                      </tr>
                <?php 
                    }
                  }
                ?>
              
              </tbody>
            </table>
        </div>
    </div>
</body>
</html>