<?php session_start();

include ('DBConnection.php');
if(isset($_SESSION['success_uporabnik'])) {

    $uporabnik = $_SESSION['username_uporabnik'];

    @$userID = $db->query("SELECT ID FROM users WHERE username='" . $uporabnik . "'")->fetchObject();
    @$IDUsr = $userID->ID;

    $sql = $db->query("SELECT * FROM prijava,izpit WHERE prijava.idizpit=izpit.id AND idUporabnik='" . $IDUsr . "'");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_OBJ);

    $izpiti = [];

    while ($row = $sql->fetchObject()) {
        $izpiti[] = $row;
    }
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
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}
    </style>
</head>
<body>
<header>
    <ul>
        <li><a href="#home">Zacetna stran</a></li>
        <li><a href="#home">Izvajalec</a>
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
            <li><a href="index.php">Prijavi se </a></li>
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
<br><br><br><br><br><br><br><br><br><br>

<form action="izbrisi_izpit_server_side.php??id=<?php echo $izpit->ID ?>" method="get">

    <table>
        <tr style="font-size: 20px"><td><b>Ime izpit</b></td><td><b>Cena</b></td><td><b>Izvajalec</b></td><td><b>Datum</b></td></tr>
        <?php
        foreach ($izpiti as $izpit):
            ?>
            <tr style="font-size:16px"><td><?php echo $izpit->IME ?></td><td><?php echo $izpit->CENA ?>&euro;</td><td><?php echo $izpit->IZVAJALEC ?></td><td><?php echo $izpit->DATUM ?></td></tr>
        <?php endforeach
        ?>
    </table>

</form>
<footer>
    <p>Vec informacij:sistemzaizpite@outlook.com</p>
    <p>@2022Sistemzaizpite</p>
</footer>
</body>
</html>