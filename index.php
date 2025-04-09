<?php
    $conn = mysqli_connect("localhost", "root", "", "gra");
    if (isset($_POST["play"])) {
        $sql = "INSERT INTO gracze ()  VALUES ()";
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

        header("Location: game.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gra Multiplayer</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="submit" name="play" value="Play">
    </form>
</body>
</html>

<?php
    mysqli_close($conn);
?>
