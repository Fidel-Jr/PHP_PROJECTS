<?php 

    // $host = "localhost";
    // $user = "root";
    // $password = "";
    // $dbname = "todo";

    

    class Database{

        private $con;

        public function __construct($host, $user, $password, $dbname)
        {
            $dsn = "mysql:host=$host;dbname=$dbname";
            $this->con = new PDO($dsn, $user, $password);
        }

        

    }
    

?>