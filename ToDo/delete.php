<?php

    require("db.php");
    $id = $_GET["id"];
    $sql = "DELETE FROM list WHERE id = ?";
    $pst = $con->prepare($sql);
    $rows = $pst->execute([$id]);
    if($pst->rowCount()>0){
        header("Location: manageTasks.php?msg=List deleted successfully");
    }
?>