
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
        
        $vardas  = $pavarde = $vartotojoVardas =  "";
        
        if (!empty($_POST ['vardas'])) {
            $vardas = ($_POST ['vardas']);
        }
        
        if (!empty($_POST ['pavarde'])) {
            $pavarde = ($_POST ['pavarde']);
        }
        
        if (!empty($_POST ['vartotojoVardas'])) {
            $vartotojoVardas = ($_POST ['vartotojoVardas']);
        }
        
        
        
        ?>
        <h2>Iveskite duomenis</h2>
        
        <form action="" method="POST">
            Vardas: <input type="text" name="vardas" value="<?php echo $vardas; ?>" required oninvalid="this.setCustomValidity('Iveskite duomenis')"><br>
            Pavarde: <input type="text" name="pavarde" value="<?php echo $pavarde; ?>" required oninvalid="this.setCustomValidity('Iveskite duomenis')"><br>
            Vartotojo vardas: <input type="text" name="vartotojoVardas" value="<?php echo $vartotojoVardas; ?>" required oninvalid="this.setCustomValidity('Iveskite duomenis')"><br>
            Slaptazodis: <input type="password" name="slaptazodis" required oninvalid="this.setCustomValidity('Iveskite duomenis')"><br>
            <input type="submit" name="pateikti" value="pateikti">
        </form>
        
        <?php
        $mysqli = mysqli_connect("localhost", "root", "", "parduotuve");
            
            if (mysqli_connect_errno()) {
                
              printf("Failed to connect to MySQL: ", mysqli_connect_error());
              exit();
              
            } else {
                
                if (isset($_POST['pateikti'])) {
                    
                    $sql= "INSERT INTO vartotojai (vardas, pavarde, vartotojo_id, slaptazodis) VALUES ('" . ($_POST['vardas']) . "', '" . ($_POST['pavarde']) . "', '" . ($_POST['vartotojoVardas']) . "', '" . ($_POST['slaptazodis']) . "')";
                    
                    $res = mysqli_query($mysqli, $sql);
              
                    if ($res) {
                        echo "<br>";
                        echo "Irasas ikeltas";
                        header('Location: prisijungimas.php');
                    }else{
                        echo "<br>";
                        printf("Prie MySQL prisijungti nepavyko: %a\n", mysqli_error($mysqli));
                        echo "<br>Toks vartotojo vardas jau egzistuoja. Iveskite kita vartotojo varda.";
                    } 
                }
           
               mysqli_close($mysqli);
            }
            
        ?>

    </body>
</html>
