<?php session_start();
date_default_timezone_set('Europe/Ljubljana');
include('DBConnection.php');
$izpit = null;
$sql=null;
if (isset($_GET['ime'])) {
    echo $id = (int)$_GET['ime'];
    $izpit = $db->query("SELECT izpit.ID,izpit.IME,izpit.CENA
    FROM izpit  
    LEFT JOIN zaporeden_pristop
    ON izpit.ID=zaporeden_pristop.izpit
    GROUP BY izpit.ID
    ")->fetchObject();

    $sql = $db->query("SELECT * FROM comment,users,izpit 
    WHERE users.id=comment.uid AND izpit.ID=comment.fid AND izpit.ID='" . $_GET['ime'] . "'");

  $sql->execute();
  $sql->setFetchMode(PDO::FETCH_OBJ);

  $komentari=[];

  while($row=$sql->fetchObject()){
      $komentari[]=$row;
  }

} else {
    // echo "NO ";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
    <style>
        li {
            display: inline-block;
            color: #F0F0F0;
            text-shadow: 0 0 1px #666666;
            font-size: 30px;
        }

        .highlight, .selected {
            color: #F4B30A;
            text-shadow: 0 0 1px #F48F0A;
        }

        textarea {
            resize: none;
            width: 400px;
            height: 80px;
            margin-left: 20px;
        }
        .table th,td{
            padding: 2px;
        }
        .comment-box{
          width: 815px;
            padding: 20px;
            margin-bottom: 4px;
            background-color: lightgrey;
            border: 4px;

        }
        .comment-box p{
            font-family: Arial;
            font-size: 14px;
            line-height: 16px;
            color: green;
        }
        .box .content{
            padding-left:20px;
        }

    </style>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script>
        function highlightStar(obj) {
            removeHighlight();
            $('li').each(function (index) {
                $(this).addClass('highlight');
                if (index == $("li").index(obj)) {
                    return false;
                }
            });
        }

        function removeHighlight() {
            $('li').removeClass('selected');
            $('li').removeClass('highlight');
        }

        function addRating(obj) {
            $('li').each(function (index) {
                $(this).addClass('selected');
                $('#rating').val((index + 1));
                if (index == $("li").index(obj)) {
                    return false;
                }
            });
        }

        function resetRating() {
            if ($("#rating").val()) {
                $('li').each(function (index) {
                    $(this).addClass('selected');
                    if ((index + 1) == $("#rating").val()) {
                        return false;
                    }
                });
            }
        }
    </script>
</head>
<header>

    <ul>
        <li><a href='index.php'>Zacetna stran</a></li>
        <li><a href="index.php">Kategorije</a>
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
<br><br><br><br><br><br>
<body>


  <?php
//VEC IMFORMACIJ ZA izpit
  if ($izpit):
    ?>


    <form action="prijaviSe.php?ID=<?php echo $izpit->ID ?>" method="post">

      <table class="table">
     <tr><td></td>
       <td><p></p></td>
      </tr>
          <tr><td><ul style="margin-left: 40px" onMouseOut="resetRating();">
                      <?php foreach (range(1, 5) as $rating): ?>

                          <a href="rate.php?izpit=<?php echo $izpit->ID; ?> & rating=<?php echo $rating; ?>">
                              <input type="hidden" name="rating" id="rating"/>

                              <li onmouseover="highlightStar(this);" onmouseout="removeHighlight();"
                                  onClick="addRating(this);">&#9733;
                              </li>

                          </a>

                      <?php endforeach; ?>
                  </ul></td></tr>
      </table>
        <br>
        <br>

        <table style="margin-left: 20px">
            <tr style="font-size: 20px"><td><b>Ime izpita</b></td><td><b>Cena</b></td><td></td><td><b>Datum</b></td><td></td></tr>
            <tr style="font-size:16px" ><td><?php echo $izpit->IME ?></td><td><?php echo $izpit->CENA?>&euro;</td><td><?php echo $izpit->IZVAJALEC?></td><td><?php echo $izpit->PROSTORIJA?></td><td><?php echo $izpit->DATUM ?></td>

        </table>
        <br><br><br><br>
        <button  style="margin-left: 20px" type="submit" name="kupi" value="<?php echo $izpit->ID ?>">Prijavi se</button>
    </form>

    <hr>
<br>
<br>
<?php
endif;

// KOMENTARI ZA izpit
@$session = $_SESSION['username_uporabnik'];
@$userID = $db->query("SELECT ID FROM users WHERE username='" . $session . "'")->fetchObject();
//   echo "USER ID :".$userID->ID;
@$IDUsr = $userID->ID;

if ($izpit):
    $izpit_id = $izpit->ID;
    echo " <form method='post' action='insertComment.php'>
        <input type='hidden' name='uid' value='" . @$IDUsr . "'>
        <input type='hidden' name='izpitid' value='" . $izpit_id . "'>
        <input type='hidden' name='date' value='" . date('Y-m-d H:i:s') . "'>
        <textarea name='message'></textarea><br>
        <button  style='margin-left: 20px' type='submit' name='komentiraj' >Komentiraj</button>
        </form>";
endif;

foreach ($komentari as $komentar):
    echo "<div class='comment-box'><p>";
    echo $komentar->username . "<br>";
    echo $komentar->date_f . "<br>";
    echo nl2br($komentar->message) . "<br>";
    echo "</p></div>";
endforeach;


?>


</body>
</html>