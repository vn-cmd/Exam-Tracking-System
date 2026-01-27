<?php session_start();

include ('DBConnection.php');
//include  ('VeciInfoizpit.php');
if(isset($_SESSION['username_uporabnik'])){
    if (isset($_POST['komentiraj'])) {
        $userid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];
        $izpit_id = $_POST['izpitid'];

        $sql = $db->prepare("INSERT INTO comment (uid,fid,date_f,message) VALUES ('$userid','$izpit_id','$date','$message')");
        $sql->execute();
       header("Location:VeciInfoizpit.php?ime=" . $izpit_id);
    }
}else{
    header("Location:prijava_uporabnik.php");
}


?>