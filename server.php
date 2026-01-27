<?php
session_start();

$errors = array();

include('DBConnection.php');
//
//// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];


    if (empty($username)) {
        array_push($errors, "Potrebno je vnositi uporabnisko ime");
    }
    if (empty($email)) {
        array_push($errors, "Potrebno je vnositi uporabnisko email");
    }
    if (empty($password_1)) {
        array_push($errors, "Potrebno je vnositi uporabnisko geslo");
    }
    if ($password_1 != $password_2)
    {
        array_push($errors, "The two passwords do not match");
    }


   //Prvoveruva dali postoi korisnik so isto korisnicko ime i mail


    $stat=$db->query("SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1");


    $stat->execute();

    $stat->setFetchMode(PDO::FETCH_ASSOC);

    while ($row = $stat->fetch()) {

        if ($row['username']) { // if user exists
            if ($row['username'] === $username) {
                array_push($errors, "Username already exists");
            }

            if ($row['email'] === $email) {
                array_push($errors, "email already exists");
            }
        }
    }

    //Prebrojuva dali imam errors odnosno dali postoi takov korisnik ako ne postoi go kreira akauntot
    if (count($errors) == 0) {
        $password = md5($password_1);//Go sifrira pasvordot

        $stmt = $db->prepare("INSERT INTO users (username, email, password) 
  			   VALUES('$username', '$email', '$password')");

      /*  $stmt->bindParam(':username', $_POST['username']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password_1', $_POST['password_1']);*/

       $stmt->execute();

        $_SESSION['username_uporabnik'] = $username;
        $_SESSION['success_uporabnik'] = "Prijavljeni";
        header('location: index.php');
    }
}

                            //<-----ZA LOGIRANJE NA KORISNIKOT

if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    $count_checked= @count($_POST['checklist']);
  //  $selected=(string)$_POST['checklist'];
   // echo "selektirani se ".$count_checked." opcii";

    if(@$count_checked<1){
        array_push($errors,"Prosim izberite eno možnost");
    }
    elseif(@$count_checked>1){

        array_push($errors,"Prosim izberite eno možnost");
    }
    elseif (@$count_checked==1) {
        foreach ($_POST['checklist'] as $selected) {
            if ($selected == 'user') {
                if (count($errors) == 0) {
                    $password = md5($password);

                    $log=$db->prepare("SELECT * FROM users WHERE username='$username' AND password='$password'");

                    /* $log->bindParam(':username', $_POST['username']);
                     $log->bindParam(':email', $_POST['email']);
                    */
                    $log->execute(
                        array(
                            'username' =>$_POST['username'],
                            'password' =>$_POST['password']
                        )
                    );

                    $count=$log->rowCount();
                    if($count>0){
                        $_SESSION['username_uporabnik'] = $username;
                        $_SESSION['success_uporabnik'] = "Prijavljen uporabnik:";
                        header('location: index.php');
                    }
                    else{
                        $msg="Napacno geslo in uporabnisko ime";
                    }

                    if(isset($msg)){
                        echo '<label class="text-danger">'.$msg.'</label>';
                    }
                }
            }

            elseif($selected=='admin'){
                    if (count($errors) == 0) {

                        $log=$db->prepare("SELECT * FROM administrator WHERE IME='$username' AND GESLO='$password'");

                        /* $log->bindParam(':username', $_POST['username']);
                         $log->bindParam(':email', $_POST['email']);
                        */
                        $log->execute(
                            array(
                                'username' =>$_POST['username'],
                                'password' =>$_POST['password']
                            )
                        );

                        $count=$log->rowCount();
                        if($count>0){
                            $_SESSION['username_admin'] = $username;
                            $_SESSION['success_admin'] = "Prijavljen admin:";
                            header('location:index.php');
                        }
                        else{
                            $msg="Napacno geslo in uporabnisko ime";
                        }

                        if(isset($msg)){
                            echo '<label class="text-danger">'.$msg.'</label>';
                        }
                    }
            }
            else{
                echo " ";
            }
        }
    }


}

?>