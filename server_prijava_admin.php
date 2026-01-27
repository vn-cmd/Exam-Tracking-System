<?php

session_start();

$errors=array();
include('DBConnection.php');

if(isset($_POST['login_admin'])) {
    $adminName = $_POST['name'];
    $adminPass = $_POST['password'];

    if (empty($adminName)) {
        array_push($errors, "Zahtevano je ime");
    }
    if (empty($adminPass)) {
        array_push($errors, "Zahtevano je geslo");
    }

    if (count($errors) == 0) {

        $log = $db->prepare("SELECT * FROM administrator WHERE IME='".$adminName."' AND GESLO='".$adminPass."'");

        $log->execute(
            array(
                'username' => $_POST['name'],
                'password' => $_POST['password']
            )
        );

        $count = $log->rowCount();
        if ($count > 0) {
            $_SESSION['username_admin'] = $adminName;
            $_SESSION['success_admin'] = "Prijavljen admin:";
            header('location:index.php');
        } else {
            $msg = "Napacno geslo in uporabnisko ime";
        }

        if(isset($msg)){
            echo '<label class="text-danger">'.$msg.'</label>';
        }
    }

}




?>