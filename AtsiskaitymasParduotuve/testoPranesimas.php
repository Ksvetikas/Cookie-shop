
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
        
        $mysqli = mysqli_connect("localhost", "root", "", "parduotuve");
            
        $sql= "SELECT vertinimo_vidurkis FROM vertinimas WHERE vartotojo_id = '" . ($_COOKIE['ponas']) . "' ORDER BY eil_nr DESC LIMIT 1";
        $res = mysqli_query($mysqli, $sql);
        $vertinimuVidurkis = mysqli_fetch_array($res, MYSQLI_ASSOC);

        echo "<h4> Aciu uz ivertinima. Jusu vertinimo vidurkis " . $vertinimuVidurkis['vertinimo_vidurkis'] . " .</h4>";
        mysqli_close($mysqli);
        
        if (isset($_POST['grizti'])) {
            
            header ('Location: vidus.php');
        }
        ?>
        
        <form action="" method="POST">
        <input type="submit" name="grizti" value="Grizti i parduotuve"></input>
        </form>
        
    </body>
</html>
