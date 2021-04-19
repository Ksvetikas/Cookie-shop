
        <?php
        if (empty($_COOKIE['ponas'])){
            header ('Location: prisijungimas.php');
        }
        
        
        $vartotojoVardas = '';
        if(isset($_POST['vartotojoVardas'])){
            $vartotojoVardas = $_POST['vartotojoVardas'];
        }
        
        
        if (isset($_POST['atsijungti'])) { 
            
            $delete3= "DELETE FROM cart_userid";
            $resDelete3 = mysqli_query($mysqli, $delete3);
            
            setcookie("ponas", $vartotojoVardas, time() - 14400);
            header ('Location: prisijungimas.php');
            
        }
        ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <h1>Sveiki, atvyke i parduotuve <?php echo $_COOKIE['ponas']; ?>.</h1>
        <h2>Prekes.</h2>
        
        <?php
        
//        Prekiu saraso spausdinimas
        echo "<table><tr><th>Prekes kodas</th><th>Pavadinimas</th><th>Likutis</th><th>kaina</th></tr>";
        
        $mysqli = mysqli_connect("localhost", "root", "", "parduotuve");
            
        if (mysqli_connect_errno()) {

            printf("Failed to connect to MySQL: ", mysqli_connect_error());
            exit();

        } else {
            $sql= "SELECT prekes_id, pavadinimas, kiekis, kaina FROM prekes";
                    
            $res = mysqli_query($mysqli, $sql);
        }
             
                
        $maxId = 0;
        
        
        while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            
            if ($row['prekes_id'] > $maxId) {
                $maxId = $row['prekes_id'];
            }
            
            echo "<tr><td>" . $row['prekes_id'] . "</td><td>" . $row['pavadinimas'] . "</td><td>" .  $row['kiekis'] . "</td><td>" .  $row['kaina'] . "Eur.</td></tr>";
        }
                
        echo "</table>";
        
//        Prekiu saraso spausdinimas
        ?>
        
        
        <h2>Iveskite savo uzsakyma.</h2>
        <br>
        <form action="" method="POST">
            <input type="hidden" name="vartotojoVardas" value="<?php echo $_POST['vartotojoVardas']; ?>">
            <input type="number" name="preke" placeholder="Prekes kodas" oninput="this.setCustomValidity('')"></input>
            <input type="number" name="kiekis" placeholder="kiekis" oninput="this.setCustomValidity('')"></input>
            <input type="submit" name="pateikti" value="Ideti i krepseli"></input><br><br>
        </form>
        <?php 
        
//        Prekiu pridejimas i krepseli
        $preke = $kiekis = 0;
        
        if (isset($_POST['preke'])) {
            $preke = $_POST['preke'];
        }
        
        if (isset($_POST['kiekis'])) {
            $kiekis = $_POST['kiekis'];
        }
        
        if ((isset($_POST['pateikti'])) && (isset($_POST['preke']) && ($preke > 0) && ($preke <= $maxId)) && (isset($_POST['kiekis']) && ($kiekis  > 0))) { 
             
            echo "<h4>I Jusu uzsakyma itraukta preke, kurios kodas yra " . $preke . ". Prekes kiekis " . $kiekis . " vnt. </h4><br>";
            
            echo "<form action='' method ='POST'>";
            echo "<input type='submit' name='uzbaigti' value='Baigti apsipirkima'></input><br>";
            echo "</form>";
            
            $sql= "INSERT INTO cart_userid (prekes_id, kiekis) VALUES ('$preke', '$kiekis')";  
            $res = mysqli_query($mysqli, $sql);
            
        } elseif (isset($_POST['pateikti'])) {
            
            echo "<h3> Iveskite prekes eiles nr., kuris nurodytas prie prekes ir jos kieki.</h3>";
        }
//        Prekiu pridejimas i krepseli
            
//        Uzsakymo uzbaigimas
        
            $sqlDataCheck= "SELECT prekes_id FROM cart_userid";
            $resDataCheck = mysqli_query($mysqli, $sqlDataCheck);
            $dataCheck = mysqli_fetch_array($resDataCheck, MYSQLI_ASSOC);
            
            
        if (isset($_POST['uzbaigti']) && ($dataCheck != NULL)){         
            
            $prekesId = '';
            
            date_default_timezone_set('Europe/Vilnius');
            $date = date('Y-m-d');
            
            $sql= "INSERT INTO uzsakymai (vartotojai_id, uzsakymo_data) VALUES ('" . ($_COOKIE['ponas']) . "', '$date')";
            mysqli_query($mysqli, $sql);
        
        
            $sql2= "SELECT uzsakymo_id FROM uzsakymai WHERE vartotojai_id='" . ($_COOKIE['ponas']) . "' ORDER BY uzsakymo_id DESC LIMIT 1";            
            $res2 = mysqli_query($mysqli, $sql2);
            $uzsakymaiIdArray = mysqli_fetch_array($res2, MYSQLI_ASSOC);
            
            $uzsakymaiId = $uzsakymaiIdArray['uzsakymo_id'];


            $sql3= "UPDATE cart_userid SET uzsakymai_id = '$uzsakymaiId' WHERE prekes_id IS NOT NULL";
            mysqli_query($mysqli, $sql3);
            
            $sql4= "INSERT INTO uzsakymo_prekes SELECT * FROM cart_userid";
            mysqli_query($mysqli, $sql4);
            
            $delete= "DELETE FROM cart_userid";
            mysqli_query($mysqli, $delete);
            
            
            $sql5= "SELECT * FROM uzsakymo_prekes WHERE uzsakymai_id = '$uzsakymaiId'";
            $res5 = mysqli_query($mysqli, $sql5);
            
            echo "<h2>Jusu uzsakymas</h2>";
            echo "<table>";
            echo "<tr><th>Prekes kodas<th>Pavadinimas</th><th>Kiekis</th><th>Kaina</th><th>Suma</th></tr>";    
            
            $bendraSuma = 0;
            $Suma = 0;
            
            while($row5 = mysqli_fetch_array($res5, MYSQLI_ASSOC)) {
                
                $sql6= "SELECT prekes_id, kiekis FROM uzsakymo_prekes WHERE uzsakymai_id = '$uzsakymaiId'";
                $res6 = mysqli_query($mysqli, $sql6);
                $row6 = mysqli_fetch_array($res6, MYSQLI_ASSOC);
                
                $sql7= "SELECT pavadinimas, kaina FROM prekes WHERE prekes_id = '" . $row5['prekes_id'] . "'";
                $res7 = mysqli_query($mysqli, $sql7);
                $row7 = mysqli_fetch_array($res7, MYSQLI_ASSOC);
                
                $suma = $row7['kaina'] * $row6['kiekis'];
                $bendraSuma += $suma;
                
                echo "<tr><td>" . $row6['prekes_id'] . "</td><td>" . $row7['pavadinimas'] . "</td><td>" .  $row6['kiekis'] . "</td><td>" .  $row7['kaina'] . "Eur.</td><td>" .  $suma . "Eur.</td></tr>";
            }
            
            echo "</table>";
            echo "<h2>Bendra suma = " . $bendraSuma . " eur.</h2>";
            
            $sql8= "UPDATE uzsakymai SET uzsakymo_suma = '$bendraSuma' WHERE uzsakymo_id = '$uzsakymaiId'";
            mysqli_query($mysqli, $sql8);
            
            unset($_POST['pateikti']);
            unset($_POST['preke']);
            unset($_POST['kiekis']);
            unset($_POST['uzbaigti']);
        }
//        Uzsakymo uzbaigimas
        ?>
        
        <form method="POST" action="">
            <input type="submit" name="isNaujo" value="Pradeti nauja apsipirkima"></input><br>
        </form>
        <?php 
        
//        Krepselio isvalymas
        if (isset($_POST['isNaujo'])) {
            
            $delete2= "DELETE FROM cart_userid";
            $resDelete2 = mysqli_query($mysqli, $delete2);
            
            unset($_POST['pateikti']);
            unset($_POST['preke']);
            unset($_POST['kiekis']);
            unset($_POST['uzbaigti']);
            
            header ('Location: vidus.php');
        }
//        Krepselio isvalymas
        mysqli_close($mysqli);
        ?>
        <form action="" method="POST">
            <input type="submit" name="testas" value="Aptarnavimo kokybes ivertinimas"></input><br><br>
            <input type="submit" name="atsijungti" value="Atsijungti"></input>
        </form><br>
        
        <?php 
//                Vertinimo anketa
        if (isset($_POST['testas'])) {

            header ('Location: testas.php');
        }
        ?>
    </body>
</html>
