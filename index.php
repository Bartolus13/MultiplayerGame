<?php
    $conn = mysqli_connect("localhost", "root", "", "gra");
    if (isset($_POST["play"])) {
        $sql = "INSERT INTO gracze ()  VALUES ()";
        mysqli_query($conn, $sql);
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
