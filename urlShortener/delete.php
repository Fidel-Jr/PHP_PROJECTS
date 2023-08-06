<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "url_shortener_db";

    $dsn = "mysql:host=$host;dbname=$dbname";
    $con = new PDO($dsn, $user, $password);
    if(isset($_GET["id"])){
        $sql = "DELETE FROM url WHERE id=?";
        $pst = $con->prepare($sql);
        $pst->execute([$_GET["id"]]);
        if($pst->rowCount()>0){
            header("Location: index.php?msg=Deleted Successfully");
        }
    }

?>