<?php
    $conn = mysqli_connect("localhost", "uczen", "qazwsx", "gra");
    if (isset($_POST["play"])) {
        if (isset($_POST["nick"])) {
            $nick = $_POST["nick"];
            $sql = "INSERT INTO gracze (nick)  VALUES ('$nick')";
        } else {
            $sql = "INSERT INTO gracze ()  VALUES ()";
        }
        
        mysqli_query($conn, $sql);
        $sql = 'SELECT MIN(liczba_graczy) FROM pomieszczenia';
        $minGraczy = mysqli_fetch_row(mysqli_query($conn, $sql))[0];
        $sql = "SELECT id FROM gracze ORDER BY id DESC LIMIT 1";
        $id_gracza = mysqli_fetch_row(mysqli_query($conn, $sql))[0];
        if ($minGraczy == 1) {
            $sql = "SELECT id FROM pomieszczenia WHERE liczba_graczy = 1";
            $id_pomieszczenia = mysqli_fetch_row(mysqli_query($conn, $sql))[0];
            $sql = "UPDATE pomieszczenia SET liczba_graczy = 2, id_gracza2 = $id_gracza WHERE id = $id_pomieszczenia";
            mysqli_query($conn, $sql);
        } else {
            $sql = "INSERT INTO pomieszczenia (id_gracza1, liczba_graczy, tura) VALUES ($id_gracza, 1, $id_gracza)";
            mysqli_query($conn, $sql);
            $sql = "SELECT id FROM pomieszczenia WHERE liczba_graczy = 1";
            $id_pomieszczenia = mysqli_fetch_row(mysqli_query($conn, $sql))[0];
        }
        setcookie("idGracza", $id_gracza, time() + (86400 * 30), "/");
        setcookie("idPomieszczenia", $id_pomieszczenia, time() + (86400 * 30), "/");
        setcookie("nick", $nick, time() + (86400 * 30), "/");
    
        header("Location: game.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu gry</title>
    <link rel="stylesheet" href="styl.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Tint&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Kółko i krzyżyk</h1>
    <form action="index.php" method="post">
        <input type="text" name="nick" id="nickInput" maxlength="16">
        <input type="submit" name="play" value="Play">
    </form>
    <footer>Grę wykonał Wojciech Ogórek i Bartosz Zawadzki-Pietrzak</footer>
</body>
</html>

<?php

    mysqli_close($conn);
?>
