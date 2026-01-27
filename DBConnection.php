<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'sistemzaizpite';

// include('index.php');

try {
    $db = new  PDO('mysql:host=localhost;dbname=sistemzaizpite', $user, $pass);
}
catch(PDOException $e) {
    echo $e->getMessage();
}

?>