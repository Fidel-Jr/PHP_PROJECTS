<?php 
    session_start();
    if(isset($_SESSION["user_id"])) {
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    require_once("db.php");
    require("manageToDo.php");
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $showAll = true;
    
    
    $query = "SELECT id, title, category, date, status FROM list WHERE user_id = ?";
    $pst = $con->prepare($query);
    $pst->execute([$_SESSION["user_id"]]);
    $lists = $pst->fetchAll();

    $user = new TodoList($_GET);
    $emptyTask = false;
    if(isset($_GET["search"]) && empty($_GET["task"])){
      $error = $user->search($_GET["task"],$_SESSION["user_id"]);
      $emptyTask = true;
    } else{
      $emptyTask = false;
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
      }
      button a{
        color: white;
      }
      a{
        text-decoration: none;
        color: gray;
      }
      a:hover{
        color: wheat;
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
      .searchBtn{
          margin-left: 10px; 
          border-radius: 15px; 
          height: fit-content; 
          padding: 6px 15px 6px 15px;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light">
        <div class="container-fluid bg-light">
          <img class="" src="images/todoIcon.png" alt="" width="35px" style="margin-right: 5px;">
          <a class="navbar-brand" href="#"><span style="color: rgb(255, 197, 105); font-size: 23px; font-weight: bolder;">To</span> <span style="color: rgb(55, 125, 153);font-size: 23px; font-weight: bolder;">Do</span></a>
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
                  <li><a class="dropdown-item text-dark" href="main.php">Home</a></li>
                  <li><a class="dropdown-item text-danger" href="manageTasks.php">My To Do List</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item text-dark" href="completedTasks.php">Completed Tasks</a></li>
                  <li><a class="dropdown-item text-dark" href="pendingTasks.php">Pending Tasks</a></li>
                </ul>
              </li>
              <li>
              <li>
            <a href="todayTasks.php">
              <div class="row rowHvr">
                <div class="col d-flex col1" style="height: 30px; margin-left: 15px;">
                  <img src="images/only-today.png" alt="" width="24" height="24">
                  <p class="text-secondary">Today</p>
                  <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $_SESSION["todays_task_count"]?></span>
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
                  <span class="badge bg-danger rounded-pill translate-middle" style="width: 18px;height: 15px; font-size: 8px;"><?php echo $_SESSION["nextWeek_task_count"]?></span>
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
        <div class="container mt-4" id="top">
          <?php
            if(isset($_GET["msg"])){
              $msg = $_GET["msg"];
              echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong> $msg </strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
            }
            if(!empty($messageUpdate)){
              echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
              <strong> $messageUpdate </strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
            }
          ?>
          <div class="container">
            <h1 style="color: rgb(55, 125, 153);">My Tasks <span style="font-size: 16px; color: gray; cursor: pointer;"><a href="main.php">+Add New</a></span></h1>
            <div class="row">
                <label class="mb-0" style="margin-left: 6px; color: rgb(55, 125, 153);" for="">Search Task</label>
              <div class="col d-flex">
                <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="get" class="row">
                  <div class="col">
                    <input class="form-control mb-2" type="text" name="task" value="<?php echo htmlspecialchars($_GET["task"] ?? "") ?>" style="border-radius: 15px; width: 700px; padding: 8px 10px;" placeholder="Title"> 
                    <input class="mb-3" type="submit" name="showAll" value="Show All" style="border: none ; color: rgb(55, 125, 153);">
                    <span style="color: red;"> <?php
                      if($emptyTask){
                        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong> {$error["e_search_title"]} </strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                      }  
                    ?>
                     </span>
                  </div>
                  <div class="col" style="margin-left: -25px; margin-top: 2px;">
                    <input type="submit" name="search" value="Search" class="searchBtn btn btn-primary">
                    
                  </div>
                    
                </form>
            </div> 
            </div>
          <div>
          <table class="container table table-striped table-hover table-responsive">

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

            <!-- Will run if search button is set or clicked -->
            <tr>
              <?php 
                if(isset($_GET["search"])){
                  $title = trim($_GET["task"]);
                  if(!empty($title)){
                    $showAll = false;
                    $search_lists = $user->search($title,$_SESSION["user_id"]);
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
                        <button type="button" name="completed" class="btn btn-success btn-sm" style="margin-right: 5px;"><a href="completed.php?id=<?php echo $list['id']?>">Completed</a></button>
                        
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
                    }else {
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
                        <button type="button" name="completed" class="btn btn-success btn-sm" style="margin-right: 5px;"><a href="completed.php?id=<?php echo $list['id']?>">Completed</a></button>
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
        </div>
      

</body>
</html>
<?php 
        }else {
          header("Location: login.php");
        }
      
?>