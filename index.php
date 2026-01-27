<?php
session_start();

   include("DBConnection.php");

    $izpit=$db->query("SELECT izpit.ID,izpit.IME,izpit.CENA
    FROM izpit  
    LEFT JOIN zaporeden_pristop
    ON izpit.ID=zaporeden_pristop.izpit
    GROUP BY izpit.ID
    ");

    $izpit->execute();
    $izpit->setFetchMode(PDO::FETCH_OBJ);

    $izpiti=[];

    while ($row=$izpit->fetchObject())
    {
        $izpiti[]=$row;
    }

?>
<!DOCTYPE html>
<html lang="en">
<link href="style.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <style type="text/css">
    </style>
</head>
<body>
<header>

<ul>
    <li><a href='index.php'>Zacetna stran</a></li>
    <li><a href="index.php">Izvajalec</a>
        <ul>
                <li><a href="sortiraj.php?izvajalec=IztokPeterin">Iztok Peterin</a></li>
                <li><a href="sortiraj.php?izvajalec=MarjanHericko">Marjan Hericko</a></li>
                <li><a href="sortiraj.php?izvajalec=DraganaBozovic">Dragana Bozovic</a></li>
                <li><a href="sortiraj.php?izvajalec=LukaPavlic">Luka Pavlic</a></li>
                <li><a href="sortiraj.php?izvajalec=LukaHrgarek">Luka Hrgarek</a></li>
                <li><a href="sortiraj.php?izvajalec=ViliPodgorelec">Vili Podgorelec</a></li>
        </ul>
    </li>
    <?php if(isset($_SESSION['success_uporabnik'])): ?>
    <li><a href="prijaveIzpit_uporabnik.php">Vase prijave</a></li>
    <?php endif ?>
    <?php if(isset($_SESSION['success_admin'])): ?>
        <li><a href="admin_dodajanje_izpit.php">Dodaj izpit</a></li>
    <?php endif ?>
    <?php if(isset($_SESSION['success_admin'])): ?>
        <li><a href="izbrisi_izpit_admin_side.php">Izbrisi izpit</a></li>
    <?php endif ?>
    <?php if(isset($_SESSION['success_admin'])||isset($_SESSION['success_uporabnik'])): ?>
    <li><a href="logout.php?Uporabnik=<?php if(isset($_SESSION['success_admin'])){
            echo $_SESSION["username_admin"];
        }elseif (isset($_SESSION['success_uporabnik'])){
            echo $_SESSION['username_uporabnik'];
        } ?>">Odjava</a></li>
    <?php  endif ?>
    <?php if(!isset($_SESSION['success_uporabnik'])): ?>
    <li><a href="Prijava.php">Prijava</a></li>
    <?php endif ?>
    <?php if(!isset($_SESSION['success_uporabnik'])): ?>
    <li><a href="registracija.php">Registracija</a></li>
    <?php endif ?>
    <li style="font-size:17px"><a> <?php if(isset($_SESSION['success_admin'])){
                echo $_SESSION['success_admin'].' '.$_SESSION['username_admin'];
            }elseif (isset($_SESSION['success_uporabnik'])){
                echo $_SESSION['success_uporabnik'].' '.$_SESSION['username_uporabnik'];
            }
            ?></a></li>
    <ul>
</header>
<br><br><br><br><br>
<br><br>


<div class="w3-main w3-content w3-padding" style="max-width:1200px;margin-top:100px">

    <div class="w3-row-padding w3-padding-16 w3-center" id="food">
        <?php
        foreach ($izpiti as $izpit):
           $ra=round($izpit->pristop);
        ?>
    <form action="VecInfoIzpit.php?ID=<?php echo $izpit->ID ?>" method="get" enctype="multipart/form-data">

        <div class="w3-quarter">
           <?php

            ?>
            <div class="zvezda">
            <?php
            for ($i=1;$i<=5;$i++) {
                if ($ra >= 1) {
                    $ra--;
                } else {
                    if ($ra >= 0.5) {
                        $ra -= 0.5;
                    } else {
                    }
                }
            }
            ?>
            </div>
            <p><?php echo $izpit->IME ?></p>
   <!-- <p>Preostalih mestih:<?php //echo $izpit->PREOSTALIH_MESTIH ?><p> -->
        <button type="submit" name="ime" value="<?php echo $izpit->ID ?>" style="border:none ; background-color:whitesmoke ;color:green" >Vec informacij...</button>
        </div>
    </form>

    <?php
        endforeach;

        ?>
</div>
</div>

    <footer>
        <p><i>© 2022 Sistem za izpite</i></p>
      <p><i>Kontakt:sistemzaizpite@outlook.com</i></p>
    </footer>
</body>
</html>