<?php

 include ('DBConnection.php');

 if(isset($_GET['id'])){

     $sql=$db->prepare("DELETE from izpit WHERE ID='".$_GET['id']."'");
     $sql->execute();

     header("Location:izbrisi_izpit_admin_side.php");
 }

?>