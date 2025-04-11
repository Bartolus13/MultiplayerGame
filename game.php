<?php

    $conn = mysqli_connect("localhost" ,"root", "", "gra");
    header('refresh: 2');
    $id_gracza = $_COOKIE["idGracza"];
    $id_pomieszczenia = $_COOKIE["idPomieszczenia"];
    $nick = $_COOKIE["nick"];
    $sql = "SELECT id_gracza1, id_gracza2 FROM pomieszczenia WHERE id = $id_pomieszczenia";
    $gracze = mysqli_fetch_row(mysqli_query($conn, $sql));
    $sql = "SELECT liczba_graczy FROM pomieszczenia WHERE id = $id_pomieszczenia";
    if (mysqli_fetch_row(mysqli_query($conn, $sql))[0] == 2) {
        if ($gracze[0] == $id_gracza) {
            $id_gracza_2 = $gracze[1];
            $tura = $id_gracza;
        } else {
            $id_gracza_2 = $gracze[0];
            $tura = $id_gracza_2;
        }
        $sql = "SELECT nick FROM gracze WHERE id = $id_gracza_2";
        $nickPrzeciwnika = mysqli_fetch_row(mysqli_query($conn, $sql))[0];
    } else {
        $tura = $id_gracza;
        $id_gracza_2 = -1;
        $nickPrzeciwnika = "";
    }
    
  
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kółko i krzyżyk</title>
    <link rel="stylesheet" href="styl.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Tint&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Kółko i krzyżyk</h1>
    <header> 
        
        <p>TY: <?php echo $nick; ?> (<?php echo $id_gracza; ?>)</p><br>
        
        
        <?php
            if ($id_gracza_2 != -1) {
                echo "<p>PRZECIWNIK: $nickPrzeciwnika ($id_gracza_2)</p>";
            } else {
                echo "<p>Czekanie na przeciwnika...</p>";
            }
        ?><br>
        <p>ID GRY: <?php echo $id_pomieszczenia; ?></p>
        
        
    </header>
    
    
    <!-- Robimy grę kółko i krzyżyk -->
    <div id="plansza">
        <form action= "game.php" method="post">
        <table id="tabela">
            <tr>
                <td id="td0"><input type="submit" id="przycisk0" name="przycisk" value="0"></td>
                <td id="td1"><input type="submit" id="przycisk1" name="przycisk" value="1"></td>
                <td id="td2"><input type="submit" id="przycisk2" name="przycisk" value="2"></td>
            </tr>
            <tr>
                <td id="td3"><input type="submit" id="przycisk3" name="przycisk" value="3"></td>
                <td id="td4"><input type="submit" id="przycisk4" name="przycisk" value="4"></td>
                <td id="td5"><input type="submit" id="przycisk5" name="przycisk" value="5"></td>
            </tr>
            <tr>
                <td id="td6"><input type="submit" id="przycisk6" name="przycisk" value="6"></td>
                <td id="td7"><input type="submit" id="przycisk7" name="przycisk" value="7"></td>
                <td id="td8"><input type="submit" id="przycisk8" name="przycisk" value="8"></td>
            </tr>        
        </form>
    </div>
    <div id="centrujguzik">
    <a  id="powrot" href="index.php">Wyjście</a>
    </div>

    

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
    mysqli_close($conn);
?>