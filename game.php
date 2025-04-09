<?php

    $conn = mysqli_connect("localhost" ,"root", "", "gra");
    $id_gracza = $_COOKIE["idGracza"];
    $id_pomieszczenia = $_COOKIE["idPomieszczenia"];
    $sql = "SELECT id_gracza1, id_gracza2 FROM pomieszczenia WHERE id = $id_pomieszczenia";
    $gracze = mysqli_fetch_row(mysqli_query($conn, $sql));
    if ($gracze[0] == $id_gracza) {
        $id_gracza_2 = $gracze[1];
    } else {
        $id_gracza_2 = $gracze[0];
    }

    

    
    
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gra Multiplayer</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header> 
        <h1>Gra Multiplayer</h1>
        <h2>Witaj w grze!</h2>
        <p>Twoje ID gracza: <?php echo $id_gracza; ?></p>
        <p>Twoje ID pomieszczenia: <?php echo $id_pomieszczenia; ?></p>
    </header>
    
    
    <!-- Robimy grę kółko i krzyżyk -->
    <h3>Kółko-krzyżyk</h3>
    <div id="plansza">
        <form action= "game.php" method="post">    
        <input type="submit" id="przycisk0" name="przycisk" value="0">
        <input type="submit" id="przycisk1" name="przycisk" value="1">
        <input type="submit" id="przycisk2" name="przycisk" value="2"><br>
        <input type="submit" id="przycisk3" name="przycisk" value="3">
        <input type="submit" id="przycisk4" name="przycisk" value="4">
        <input type="submit" id="przycisk5" name="przycisk" value="5"><br>
        <input type="submit" id="przycisk6" name="przycisk" value="6">
        <input type="submit" id="przycisk7" name="przycisk" value="7">
        <input type="submit" id="przycisk8" name="przycisk" value="8"><br>
        </form>
    </div>

    <a href="index.php">WRACAJ</a>

    <?php

         $sql = "SELECT plansza FROM pomieszczenia WHERE id = $id_pomieszczenia";
         $plansza = mysqli_fetch_row(mysqli_query($conn, $sql))[0];
         for ($i = 0; $i < 9; $i++) {
             if ($plansza[$i] == "O") {
                 echo "<script> document.getElementById('przycisk$i').setAttribute('value','O')</script>";
                 echo "<script> document.getElementById('przycisk$i').setAttribute('disabled','true')</script>";
             } else if ($plansza[$i] == "X") {
                 echo "<script> document.getElementById('przycisk$i').setAttribute('value','X')</script>";
                 echo "<script> document.getElementById('przycisk$i').setAttribute('disabled','true')</script>";
             }
         }


        function klikPrzycisku($nrPrzycisku) {
            global $conn, $id_gracza, $id_gracza_2, $id_pomieszczenia;
            $sql = "SELECT tura FROM pomieszczenia WHERE id = $id_pomieszczenia";
            $tura = mysqli_fetch_row(mysqli_query($conn, $sql))[0];
            $iloscGraczy = mysqli_fetch_row(mysqli_query($conn, "SELECT liczba_graczy FROM pomieszczenia WHERE id = $id_pomieszczenia"))[0];
            
        
            if ($tura == $id_gracza && $iloscGraczy == 2) {
                $plansza = mysqli_fetch_row(mysqli_query($conn, "SELECT plansza FROM pomieszczenia WHERE id = $id_pomieszczenia"))[0];
                $sql = "SELECT id_gracza1 FROM pomieszczenia WHERE id = $id_pomieszczenia";
                if($id_gracza == mysqli_fetch_row(mysqli_query($conn, $sql))[0]) {
                    $znak = "O";
                } else {
                    $znak = "X";
                }
                if ($plansza[(int)$nrPrzycisku] == '0') {
                    $plansza[(int)$nrPrzycisku] = $znak;
                    $sql = "UPDATE pomieszczenia SET plansza = '$plansza' WHERE id = $id_pomieszczenia";
                    mysqli_query($conn, $sql);
                    echo $nrPrzycisku;
                    echo $plansza;
                    $sql = "UPDATE pomieszczenia SET tura = $id_gracza_2 WHERE id = $id_pomieszczenia";
                    mysqli_query($conn, $sql);
                    echo "<script> document.getElementById('przycisk$nrPrzycisku').setAttribute('value','$znak')</script>";
                    echo "<script> document.getElementById('przycisk$nrPrzycisku').setAttribute('disabled','true')</script>";
                }
                
                
                
            }

        }

        if (isset($_POST["przycisk"])) {
            $nrPrzycisku = $_POST["przycisk"];
            klikPrzycisku($nrPrzycisku);

        }
    ?>

</body>
</html>
<?php
    mysqli_close($conn)
?>