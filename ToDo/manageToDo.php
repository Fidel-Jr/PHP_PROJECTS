<?php 

    
    class TodoList{

        private $data;
        private $error = [];
        private $list = [];
        private static $title = "title";
        private static $category = "category";
        private static $date = "date";

        private $host = "mysql:host=localhost;dbname=todo",  $user = "root", $password = "";
        private $options = array(PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION);
        protected $con;

        public function connect(){
            try{
                $this->con = new PDO($this->host, $this->user, $this->password, $this->options);
                return $this->con;
            }catch(PDOException $e){
                echo "There is some problem in the connection :". $e->getMessage();
            }
        }

        public function closeConnection(){
            $this->con = null;
        }
       

        public function __construct($post){
            $this->data = $post;
        }

        public function getUsers(){
            $conn = $this->connect();
            $pst = $conn->prepare("SELECT * FROM user");
            $pst->execute();
            $users = $pst->fetchAll();
            $userCount = $pst->rowCount();
            if($userCount>0){
                return $users;
            } else {
                return 0;
            }
        }



        public function list(){
            if(!array_key_exists(self::$title,$this->data)){
                trigger_error(self::$title . " does not exist in data");
            } elseif(!array_key_exists(self::$category,$this->data)){
                trigger_error(self::$category . " does not exist in data");
            }elseif(!array_key_exists(self::$date,$this->data)){
                trigger_error(self::$date . " does not exist in data");
            }
        }
        
        public function add(){
            $val1 = trim($this->data["title"]);
            $val2 = trim($this->data["category"]);
            $val3 = trim($this->data["date"]);
            if(!empty($val1) && !empty($val2) && !empty($val3)){
                $connection = $this->connect();

                // $dsn = "mysql:host=$host;dbname=$dbname";
                // $con = new PDO($dsn, $user, $password);
                
                $title = $this->data["title"];
                $category = $this->data["category"];
                $date = $this->data["date"];
                $sql = "INSERT INTO list(user_id,title,category,date) VALUES(?,?,?,?)";
                $pst = $connection->prepare($sql);
                $pst->execute([$_SESSION['user_id'],$val1,$val2,$val3]);

                $this->list["title"] = $title;
                $this->list["category"] = $category;
                $this->list["date"] = $date;
                return $this->list;
            } else {
                if(empty($val1)){
                    $this->error["e_title"] = "This field cannot be empty";
                }
                if(empty($val2)){
                    $this->error["e_category"] = "This field cannot be empty";
                }
                if(empty($val3)){
                    $this->error["e_date"] = "This field cannot be empty";
                }
                return $this->error;
            }
            
            
        }

        public function search($title, $user_id){
            
            $connection = $this->connect();
            
            if(empty($title)){
                $this->error["e_search_title"] = "Please input title";
                return $this->error;
            }
            $query = "SELECT * FROM list WHERE title LIKE ? AND user_id= ?";
            $pst = $connection->prepare($query);
            $val = "%". $title . "%";
            $pst->execute([$val,$user_id]);
            $lists = $pst->fetchAll(PDO::FETCH_ASSOC);
            return $lists;
        }

        public function update($id){
            $connection = $this->connect();
            $title = $this->data["title"];
            $category = $this->data["category"];
            $date = $this->data["date"];
            if(empty($id) || empty($title) || empty($category) || empty($date)){
                return "ERROR";
            }
            
            $sql = "UPDATE list SET title = ?, category=?, date=? WHERE id=?";
            $pst = $connection->prepare($sql);
            $list = $pst->execute([$title, $category, $date, $id]);
            return "SUCCESS";
        }

    }

    

?>