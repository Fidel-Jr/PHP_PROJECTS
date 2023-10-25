<?php

    require_once('db.php');
    // $query = "SELECT * FROM list";
    $pst =$con->query("SELECT * FROM list");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Fetch Data</title>
</head>
<body>

    <div class="container row mx-auto d-block mt-5">
        <div class="col">
        <table class="table table-bordered text-center">
        <tr class="bg-dark text-white">
            <td>#</td>
            <td>Title</th>
            <td>Category</td>
            <td>Due</td>
            <td>Status</td>
        </tr>
        <tr>

            <?php 
                $rowC = 0;
                while($row = $pst->fetch(PDO::FETCH_ASSOC)){
                $rowC = $rowC + 1;

            ?>
                    <td><?php echo $rowC ?></td>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $row['category'] ?></td>
                    <td><?php echo $row['date'] ?></td>
                    <td><?php echo $row['status'] ?></td>
        </tr>
            <?php 
                
                }
            ?>

        
        </table>
        </div>
    </div>
    

</body>
</html>