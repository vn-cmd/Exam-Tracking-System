<?php include('server.php') ?>
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
<br><br><br><br><br>
<body>
<div class="header">
    <h2>Login</h2>
</div>

<form method="post" action="Prijava.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
        <label>Uporabnisko ime</label>
        <input type="text" name="username" >
    </div>
    <div class="input-group">
        <label>Geslo</label>
        <input type="password" name="password">
    </div>
    <label class="container">User
        <input type="checkbox"  name="checklist[]" id="user" value="user">
        <span class="checkmark"></span>
    </label>

    <label class="container">Admin
        <input type="checkbox" name="checklist[]"   id="admin" value="admin">
        <span class="checkmark"></span>
    </label>
    <br>
    <div class="input-group">
        <button type="submit" class="btn" name="login_user">Prijava</button>
    </div>
    <br>
    <p>
        Še niste član?<a href="registracija.php">Regitracija</a>
    </p>
    <a href="index.php">Začetna stran</a>
</form>
<footer>
<p>© 2022 Sistem za izpite</p>
    <p>Kontakt:sistemzaizpite@outlook.com</p>
</footer>
</body>
</html>