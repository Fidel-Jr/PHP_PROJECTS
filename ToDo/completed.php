<?php

    require_once("db.php");
    $id = $_GET["id"];
    $status = "Completed";
    $sql = "UPDATE list SET status=? WHERE id = ?";
    $pst = $con->prepare($sql);
    $pst->execute([$status, $id]);
    if($pst->rowCount()>0){
        header("Location: manageTasks.php?msg=New Task Completed");
    } else {
        header("Location: manageTasks.php?msg=Task is already mark as completed");
    }
?>