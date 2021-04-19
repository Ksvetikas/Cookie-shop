
        <?php
        
        if (isset($_COOKIE['ponas'])){
            
            header ('Location: vidus.php');

        } 
        ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <?php 
        
        $vartotojoVardas = "";
        
        if (isset($_POST ['vartotojoVardas'])) {
            $vartotojoVardas = $_POST['vartotojoVardas'];
        }
        ?>
        
        <h2>Noredami uzeiti i parduotuve iveskite prisijungimo duomenis.</h2>
        <br>
        
        <form action="" method="POST">
            <input type="text" name="vartotojoVardas" value="<?php echo $vartotojoVardas;?>" required oninvalid="this.setCustomValidity('Iveskite duomenis')" placeholder="Prisijungimo vardas">
            <input type="password" name="slapt" required oninvalid="this.setCustomValidity('Iveskite duomenis')" oninput="this.setCustomValidity('')" placeholder="slaptazodis">
            <input type="submit" name="prisijungti" value="Prisijungti"><br>
            <input type="submit" name="registracija" value="Registracija">
        </form>
        <?php
        
        if (isset($_POST['registracija'])){
            header('Location: registracija.php');
        }
        
        if ((isset($_POST['vartotojoVardas'])) && (isset($_POST['slapt'])) && (isset($_POST['prisijungti']))) {
            $mysqli = mysqli_connect("localhost", "root", "", "parduotuve");
            
                if (mysqli_connect_errno()) {

                  printf("Failed to connect to MySQL: ", mysqli_connect_error());
                  exit();

                } else {
                    $sql= "SELECT vartotojo_id FROM vartotojai WHERE vartotojo_id= '" . $_POST['vartotojoVardas'] . "' AND slaptazodis= '" . $_POST['slapt'] . "'";
                    
                    $res = mysqli_query($mysqli, $sql);
                    
                    $count = mysqli_num_rows($res);

                    
                    if ($count == 1) {
                        setcookie('ponas', ($_POST['vartotojoVardas']), time()+(14400));
                        header('Location: vidus.php');
                    }else {
                        echo "<br>";
                        printf("Prie MySQL prisijungti nepavyko: %a\n", mysqli_error($mysqli));
                        echo "<br>";
                        echo "<br>Ivesti neteisingi duomenys.";
                    }
                }

                mysqli_close($mysqli);
        }
        ?>
    </body>
</html>
