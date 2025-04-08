<?php
    $conn = mysqli_connect("localhost" ,"root", "", "gra");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gra Multiplayer</title>
</head>
<body>

    <?php   
            $sql = "SELECT id FROM gracze ORDER BY id DESC LIMIT 1";
            $playerID = mysqli_fetch_row(mysqli_query($conn, $sql));
            echo $playerID[0];
    ?>
    
</body>
</html>
<?php
    mysqli_close($conn)
?>