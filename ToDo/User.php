<?php
    
    function getUser($id,$db){
        $query = "SELECT * FROM user WHERE id = ?";
        $pst = $db->prepare($query);
        $pst->execute([$id]);
        if($pst->rowCount()==1){
            $user = $pst->fetch();
            return $user;
        } else {
            return 0;
        }
    }

?>