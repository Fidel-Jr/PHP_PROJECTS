<?php 

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "url_shortener_db";

    $dsn = "mysql:host=$host;dbname=$dbname";
    $con = new PDO($dsn, $user, $password);

    $pst = $con->prepare("SELECT * FROM url");
    $pst->execute(); 
    $data = $pst->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">    
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Document</title>

    <style>
        .container{
            border: 1px solid black;
            background-color: wheat;
        }
        input{
            width: 600px;
            height: 35px;
        }
        form button{
            background-color: maroon;
            color: white;
            border: none;
            padding: 3px 18px;
            border-radius: 3px;
        }
        label{
            color: maroon;
        }
        a{
            text-decoration: none;
            color: maroon;
        }
        a:hover{
            color: red;
        }
        h1{
            color: maroon;
        }
    </style>
</head>
<body>

    <center>
    
    <div class="container mx-auto d-block mt-5">
        <h1 class="mt-4 mb-5">URL Shortener</h1>
        <form class="mt-3" action="shortener.php" method="get">
            <label for="">URL:</label>
            <input type="text" name="url">
            <button type="submit" name="enter">Enter</button>
        </form>
        <table class="table mt-4 border-dark table-striped table-hover table-responsive">
            <thead>
              <tr class="bg-danger text-white">
                <th scope="col">#</th>
                <th scope="col">Shortened URL</th>
                <th scope="col">URL</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                    $count = 0; 
                    foreach($data as $d){
                        $shortUrl = $d["shorten_url"];
                        $urlToShorten = $d["orig_url"];
                        $count += 1;
                ?>
                
                    <td><?php echo $count ?></td>
                    <td><?php echo $shortUrl ?></td>
                    <td style="max-width: 500px;
                               word-break: break-all;
                               overflow-wrap: break-word;
                               overflow: hidden;">
                               <?php echo $urlToShorten ?>
                    </td>
                    <td>
                        <button><a href="delete.php?id=<?php echo $d["id"] ?>">Delete</a></button>
                        <button>Copy</button>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    </center>

</body>
</html>