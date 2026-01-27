<?php session_start();
include('DBConnection.php');

if (isset($_SESSION['username_uporabnik'])) {
    if (isset($_POST['kupi'])) {

        //  echo $_POST['kupi'];
        $idFilm = $_POST['kupi'];
        $idUser = $_SESSION['username_uporabnik'];

        //echo " ID " . $idFilm;

        @$userID = $db->query("SELECT ID FROM users WHERE username='" . $idUser . "'")->fetchObject();
        @$IDUsr = $userID->ID;
        //echo $IDUsr;

        //Dali postoi karta proveruva
        $kartaRez= $db->query("select * from karta where idUporabnik='" . $IDUsr . "' and idFilm='" . $idFilm . "'");
        $kartaRez->execute();
        $count = $kartaRez->rowCount();
    //    echo "ROW ".$count;

        if ($count == 0) {

            $sql = $db->query("INSERT INTO  karta (idFilm,	idUporabnik) VALUES ('$idFilm','$IDUsr')");
            $sql->execute();


            //Za da gi odzememe preostalih mest
            $query = $db->query("select * from film where ID='" . $idFilm . "'");
            $query->execute();
            $query->setFetchMode(PDO::FETCH_ASSOC);

            $row = $query->fetch();

            $stPreostaliMestih = $row['PREOSTALIH_MESTIH'] - 1;
            // echo 'NUMBER: '.$stPreostaliMestih;

            $stPrMs = $db->prepare("update film set PREOSTALIH_MESTIH='" . $stPreostaliMestih . "' where ID='" . $idFilm . "' ");
            $stPrMs->execute();

         header('Location:VeciInfoFilm.php?ime=' . $idFilm);

        } else {
            header('Location:VeciInfoFilm.php?ime=' . $idFilm);
        }
    }
}    else {
     header('location:prijava_uporabnik.php');
}


?>

