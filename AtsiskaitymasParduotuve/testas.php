
    <?php
    
    if (empty($_COOKIE['ponas'])){
        
        header ('Location: prisijungimas.php');
    }
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
//        Funkcijos
        function vertinimas($vardas, $klausimas){
            
            for ($i = 0; $i < count($klausimas) ; $i++) {
                
            echo "<label for=" . $vardas[$i] . " > " . $klausimas[$i] . " </label>";
            echo "<select name=" . "$vardas[$i]" . " >";
            echo "<option  value='1'>1</option>";
            echo "<option  value='2'>2</option>";
            echo "<option  value='3'>3</option>";
            echo "<option  value='4'>4</option>";
            echo "<option  value='5'>5</option>";
            echo "</select>";
            echo "<br><br>";
            }
        }
        
        function vertinimuVidurkis($vertinimas) {
            
            $vertinimuSuma = 0;
            
            for ($i = 0; $i < count($vertinimas); $i++) {
                
                $anketosBalai = $vertinimas[$i];
                $vertinimuSuma += $_POST[$anketosBalai];
            }
            
            return $vertinimuSuma / count($vertinimas);
        }
//        Funkcijos 
                
        $vertinimas = [];
        $vertinimas[] = "balas1";
        $vertinimas[] = "balas2";
        $vertinimas[] = "balas3";
        $vertinimas[] = "balas4";
        $vertinimas[] = "balas5";

        $klausimas = [];
        $klausimas[] = "Kaip vertinate prekiu kokybe?";
        $klausimas[] = "Kaip vertinate puslapio patoguma?";
        $klausimas[] = "Kaip vertinate parduotuves asortimenta?";
        $klausimas[] = "Kaip vertinate parduotuves dizaina?";
        $klausimas[] = "Kaip vertinate prekiu pristatyma?";


        ?>
        <h3>Noredami suteikti kiek tik imanoma geresnes paslaugas noretume gauti Jusu nuomone apie musu parduotuve.</h3><br>
        
        <form action="" method="POST"></input>
                
        <?php vertinimas($vertinimas,$klausimas);?>
                    
            <input type="submit" name="anketa" value="Pateikti vertinima"><br>
        <input type="submit" name="grizti" value="Grizti i puslapi">
        </form><br>
                
                
        <?php 
        
        if (isset($_POST['anketa'])) {
            
            $vertinimuVidurkis = vertinimuVidurkis($vertinimas);
            
            date_default_timezone_set('Europe/Vilnius');
            $data = date('Y-m-d');
            
            $mysqli = mysqli_connect("localhost", "root", "", "parduotuve");
            
            $sql9= "INSERT INTO vertinimas (vartotojo_id, vertinimo_vidurkis, vertinimo_data) VALUES ('" . ($_COOKIE['ponas']) . "', '$vertinimuVidurkis', '$data' )";
            $res9 = mysqli_query($mysqli, $sql9);
            
            header ('Location: testoPranesimas.php');
            
            mysqli_close($mysqli);
        }
            
        if (isset($_POST['grizti'])) {
            
            header ('Location: vidus.php');
        }
        ?>
    </body>
</html>
