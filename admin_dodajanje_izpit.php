<?php
session_start();
$errors=array();
if(isset($_SESSION['username_admin'])){
if(isset($_POST['dodaj']))
{

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'sistemzaizpite';

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }

    $izvajalecTip=array('IztokPeterin','MarjanHericko','DraganaBozovic','LukaPavlic','LukaHrgarek','ViliPodgorelec');
    $imeIzpita=$_POST['imeIzpita'];
    $izvajalec=$_POST['izvajalec'];
    $cena=$_POST['cena'];
    $datum=$_POST['datum'];
    $prostorija=$_POST['prostorija'];


    if(empty($imeIzpita)){
        array_push($errors,'Zahtevano je ime Izpita');
    }
    if(empty($izvajalec)){
        array_push($errors,'Zahtevan je izvajalec Izpita');
    }

    $m=0;
    for ($i=0;$i<count($izvajalecTip);$i++){
        if(strtolower(trim($izvajalecTip[$i]))==strtolower(trim($izvajalec))){
            $m++;
        }
    }
    if($m<1) {
        array_push($errors, 'Prosim vnesite eno od možnosti izvajalca');
    }

    if(empty($cena)){
        array_push($errors,'Zahtevana je cena');
    }
    if(empty($datum)){
        array_push($errors,'Zahtevan je datum');
    }
    if(empty($prostorija)){
        array_push($errors,'Zahtevan je vnos prostorije');
    }


    $n=count($errors);

    if($n==0) {
    //echo "PROSTORIJA :".$prostorija;
        $steviloMest=$db->prepare("SELECT Stevilo_mest FROM prostorija WHERE ID_prostorija='".$prostorija."'");
        $steviloMest->execute();
        $steviloMest->setFetchMode(PDO::FETCH_ASSOC);

        //$row=$steviloMest->rowCount();

       $row=$steviloMest->fetch() ;

           echo 'NUMBER ' . $row['Stevilo_mest'];

           $stSd=$row['Stevilo_mest'];

         $izvajalecLower=strtolower($izvajalec);
         $sql = $db->prepare("INSERT INTO izpit (IME, CENA, IZVAJALEC,DATUM) VALUES('$imeIzpita', '$cena', '$izvajalecLower','$datum')");

        $sql->execute();

    }

}
}
else{
     header('location:prijava_admin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<link href="nov.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karma">
    <style type="text/css">
        *{
            box-sizing: border-box;
        }
        body{
            background:whitesmoke;
            margin: auto;
        }
        header{
            background:darkgray;
            text-align: center;
            font-size: 40px;
            color: white;
            width:100%;
            height: 117px;
            top: 0;
            position: fixed;
            padding: 30px;
        }
        .input{
            border-radius: 5px;
            border: 1px solid darkgray;
        }

        .content{
            width: 100%;
            position: relative;
            top:400%;
            height: 1000px;
            font-size:25px;

        }
        ul{
            top: 0;
            list-style: none;

        }
        ul li{
            float:left;
            width: 200px;
            height: 40px;
            background-color: darkgray;
            opacity: .8;
            line-height: 20px;
            text-align: center;
            font-size: 28px;
            margin-right: 4%;

        }
        ul li a{
            text-decoration:none;
            color:lawngreen;
            display:block;

        }
        ul li a:hover{
            background-color: darkcyan;
        }
        ul li ul li{
            display: none;
        }
        ul li:hover ul li {
            display:block;
        }
        .form{
            border: 1px solid green;
        }

        footer{
            background-color:darkgray;
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100px;
            position: fixed;
        }
        footer p{
            text-align: right;
        }
        textarea{
            resize: none;
        }

    </style>
</head>
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
            <li><a href="index.php">Prijavi se</a></li>
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
<br><br><br><br><
<body>
   <div class="header">
        <h2>Dodaj izpit</h2>
   </div>

<form action="admin_dodajanje_izpit.php" method="post" enctype="multipart/form-data">
    <?php include('errors.php'); ?>
    <div class="input-group">
        <label>Ime Izpita</label>
        <input type="text" name="imeIzpita" >
    </div>
    <div class="input-group">
        <label>Izvajalec izpita</label>
        <label style="font-size: 15px">(Izberite enega)</label>
        <input type="text" name="izvajalec">
    </div>
    <div class="input-group">
        <label>Cena</label>
        <input type="text" name="cena">
    </div>
    <div class="input-group">
        <label>Datum</label>
        <input type="date" name="datum">
    </div>
    <div class="prostorijaInout">
        <label>Prostorija</label>
        <input type="number" name="prostorija" >
    </div>

       </form>

    </body>
</html>



