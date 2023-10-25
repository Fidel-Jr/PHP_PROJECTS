<?php 

session_start();

if(isset($_SESSION["user_id"])) {
    include 'db.php';
    $id = $_SESSION["user_id"];
    if(isset($_POST["username"])){
        $new_username = trim($_POST["username"]);
        $new_password =trim($_POST["password"]);
        $old_pp = $_POST["old_pp"];
        if(empty($new_username) || empty($new_password)){
            header("Location: updateUser.php?error=Please input all fields");
        } 
        else{

          if(isset($_FILES["profile"]["name"]) && !empty($_FILES["profile"]["name"])){

            $img_name = $_FILES["profile"]["name"];
            $img_size = $_FILES["profile"]["size"];
            $tmp_name = $_FILES["profile"]["tmp_name"];
            $error = $_FILES["profile"]["error"];
            
            if($error===0){
             $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
             $img_ex_to_lwr = strtolower($img_ex);
             $allowed_exs = array("jpg","jpeg", "png");
             if(in_array($img_ex_to_lwr, $allowed_exs)){
               $new_img_name = uniqid($new_username,true).'.' .$img_ex_to_lwr;
               $img_upload_path = "profiles/".$new_img_name;
               $old_pp_des = "profiles/$old_pp";
               if(unlink($old_pp_des)){
                move_uploaded_file($tmp_name, $img_upload_path);
               } else {
                move_uploaded_file($tmp_name, $img_upload_path);
               }
               $hash = password_hash($new_password,PASSWORD_DEFAULT);
               $query = "UPDATE user SET username = :username, password = :password, profile_picture = :profile_picture WHERE id = :id";
               $pst = $con->prepare($query);
               $pst->execute(["username"=>$new_username, "password"=>$hash, "profile_picture"=>$new_img_name, "id"=>$id]);
               echo $_SESSION["profile_pic"];
               header("Location: updateUser.php?success=Profile Updated Successfully!");
               exit;
             } else {
               header("Location: updateUser.php?error=You can't upload files of this type!");
             }
            } else {
             header("Location: updateUser.php?error=unknown error occurred!");
            }
        
           } else{
            if(!preg_match("/^[a-zA-Z0-9]{6,12}$/", $new_username)){
              echo "username must be 6-12 chars & alphanumeric";
            } else {
              $hash = password_hash($new_password,PASSWORD_DEFAULT);
              $query = "UPDATE user SET username = ?, password = ? WHERE id= ?";
              $pst = $con->prepare($query);
              $pst->execute([$new_username, $hash, $_SESSION["user_id"]]);
              if($pst->rowCount()>0){
                  header("Location: updateUser.php?success=Profile Updated Successfully!");
                  exit;
              }
            }
           }

            
           
        }
    }
}
?>