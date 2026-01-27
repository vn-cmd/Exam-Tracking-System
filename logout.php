<?php

session_start();

/*echo "Zdravo";
echo $_GET['username_uporabnik'];*/


if(isset($_GET['Uporabnik'])){
    session_destroy();
   header("Location:index.php");
}

?>

