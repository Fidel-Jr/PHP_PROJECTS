<?php 

    class User{

        private $data;
        private $errors = [];
        private static $properties = ["firstname","lastname","username","password","gender","age"];

        public function __construct($post)
        {
            $this->data = $post;            
        }

        public function validateForm(){
            foreach(self::$properties as $property){
                if(!array_key_exists($property,$this->data)){
                    trigger_error("$property is not present in data");
                    return;
                }
            }
            $this->validateFirstname();
            $this->validateLastname();
            $this->validateUsername();
            $this->validatePassword();
            $this->validateAge();
            return $this->errors;
        }

        private function validateFirstname(){
            $val = trim($this->data["firstname"]);
            if(empty($val)){
                $this->addError("firstname", "this field cannot be empty");
            } else {
                if(!preg_match("/^[A-Za-z]+$/", $val)){
                    $this->addError("firstname", "Contains only letters");
                }
            }
        }

        private function validateLastname(){
            $val = trim($this->data["lastname"]);
            if(empty($val)){
                $this->addError("lastname", "this field cannot be empty");
            } else {
                if(!preg_match("/^[A-Za-z\s]+$/", $val)){
                    $this->addError("lastname", "Contains only letters");
                }
            }
        }

        private function validateUsername(){
            $val = trim($this->data["username"]);
            if(empty($val)){
                $this->addError("username", "this field cannot be empty");
            } else {
                if(!preg_match("/^[a-zA-Z0-9]{6,12}$/", $val)){
                    $this->addError("username", "username must be 6-12 chars & alphanumeric");
                }
            }
        }

        private function validatePassword(){
            $val = trim($this->data["password"]);
            if(empty($val)){
                $this->addError("password", "this field cannot be empty");
            } else {
                if(!preg_match("@[0-9]@", $val) || strlen($val) < 8){
                    $this->addError("password", "password must be 8 characters in length and it should contains a number");
                }
            }
        }

        private function validateAge(){
            $age = $this->data["age"];
            if(empty($age)){
                $this->addError("age", "this field cannot be empty");
            }
            else {
                if (!preg_match('/^\d+$/', $age)) {
                    $this->addError("age", "Please input a valid number");
                } 
            }
            
        }

        private function addError($key,$val){
            $this->errors[$key] = $val;
        }

    }

?>