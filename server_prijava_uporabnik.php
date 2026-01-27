<?php

session_start();
$errors=array();

include("DBConnection.php");

if(isset($_POST['login_user'])){
    $userName=$_POST['username'];
    $pass=$_POST['password'];

    if(empty($userName)){
        array_push($errors,'Zahtevano je uporabnisko ime');
    }
    if(empty($pass)){
        array_push($errors,'Zahtevano je geslo');
    }

    if(count($errors)==0){

        $password=md5($pass);
        $query=$db->prepare("SELECT * FROM users WHERE username='".$userName."' AND password='".$password."'");

    $query->execute(
       array( 'username' => $_POST['username'],
                'password' => $_POST['password']
    ));

        $count = $query->rowCount();
        if ($count > 0) {
            $_SESSION['username_uporabnik'] = $userName;
            $_SESSION['success_uporabnik'] = "Prijavljen uporabnik:";
            header('location: index.php');
        } else {
            $msg = "Napacno geslo in uporabnisko ime";
        }

        if(isset($msg)){
            echo '<label class="text-danger">'.$msg.'</label>';
        }
    }
}

?>