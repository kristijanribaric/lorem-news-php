<?php
session_start();
if(isset($_POST['submit']) && !empty($_POST['naslov_edit'])) {
    $naslov_edit = $_POST['naslov_edit'];
    include 'connect.php';
    $sql = 'SELECT id,naslov,kratki,slika,dugi,kategorija,arhiva from clanak WHERE LOWER(naslov) = ?';
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt,'s',$naslov_edit);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $id_temp, $naslov_temp,$kratki_temp,$slika_temp,$dugi_temp,$kategorija_temp,$arhiva_temp);
    }
    if(mysqli_stmt_num_rows($stmt)>0){
        while ($row = mysqli_stmt_fetch($stmt)) {
            $id = $id_temp;
            $naslov = $naslov_temp;
            $kratki = $kratki_temp;
            $slika = $slika_temp;
            $dugi = $dugi_temp;
            $kategorija = $kategorija_temp;
            $arhiva = $arhiva_temp;
        }
        if($arhiva == 0) {
            $checked= "";
        }
        else {
            $checked= "checked";
        }
        
    }
    else {
        $error = "<p>Ne postoji članak s tim naslovom.</p>";
    }

    
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lorem News</title>
    <link rel="icon" href="img/news_logo.png" type="image/gif" sizes="16x16">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="account">
                <?php if(isset($_SESSION['username'])){
                    echo '<a href="login.php?logout=1">Log out</a>';} 
                else {
                    echo '<a href="login.php">Log in</a>';
                }
                ?>
            </div>

            <div class="logo">
                <img src="img/news_logo_red.png" alt="news_logo">
                <h1>Lorem<span class="news">News</span></h1>
            </div>
            
            <nav>
                <a href="index.php">Početna</a>
                <a href="kategorija.php?id=sport">Sport</a>
                <a href="kategorija.php?id=kultura">Kultura</a>
                <a href="kategorija.php?id=politika">Politika</a>
                <a href="kategorija.php?id=zabava">Zabava</a>
                <a href="unos.php">Predaj članak</a>
                <a class="active" href="administracija.php">Administracija</a>
            </nav>
        </header>
        
        <section>
            <?php if(isset($_SESSION['username']) && isset($_SESSION['razina'])) {
                 if($_SESSION['razina'] == 0){
                    echo "<p>Pozdrav ".$_SESSION['ime'].". Nemate ovlasti za pristup administratorskoj stranici.</p>";
                    echo '<a class="registration_link" href="index.php">Povratak na početnu stranicu</a>';
                }
                else{
                    echo '<form method="POST" action = "'.htmlspecialchars($_SERVER['PHP_SELF']).'">
                    <label for="naslov_edit">Unesi naslov članka (sve malim slovima):</label>
                    <input type="text" name="naslov_edit" id="naslov_edit"/> <br>
                
                    <button type="submit" class="button" name="submit" id="submit">Traži</button>
                    </form>';}
                } 
                else {header("Location:login.php"); exit();}
            ?>
            
            
        </section>
        <section>
        <?php  if(isset($error)){echo $error;} ?>
           <?php if(isset($id)){
               echo ' <form method="POST" action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" enctype="multipart/form-data" name="forma">

               <div class="row">
                   <div class="col-25">
                       <label for="naslov">Naslov</label>
                   </div>
                   <div class="col-75">
                    <input type="hidden" name="id" value="'.$id.'">
                       <input type="text" name="naslov" value="'.$naslov.'">
                   </div>
               </div>
               <div class="row">
                   <div class="col-25">
                       <label for="kratki">Kratki sadržaj vijesti (do 50 znakova)</label>
                   </div>
                   <div class="col-75">
                       <textarea name="kratki"  cols="40" rows="6">'.$kratki.'</textarea>
                   </div>
               </div>
               <div class="row">
                   <div class="col-25">
                       <label for="dugi">Sadržaj vijesti</label>
                   </div>
                   <div class="col-75">
                       <textarea name="dugi" cols="80" rows="14">'.$dugi.'</textarea>
                   </div>
               </div>
               <div class="row">
                   <div class="col-25">
                       <label for="slika">Slika</label>
                   </div>
                   <div class="col-75">
                        <input type="hidden" name="slika_old" value="'.$slika.'">
                        <input type="file" name="slika" id="slika">
                       
                        <br><br><img src="'. $slika . '" width=50%>
                   </div>
               </div>
               <div class="row">
                   <div class="col-25">
                       <label for="kategorija">Kategorija</label>
                   </div>
                   <div class="col-75">
                       <select name="kategorija">
                           <option value="sport" ';if($kategorija == "sport"){echo 'selected';} echo '>Sport</option>
                           <option value="kultura" ';if($kategorija == "kultura"){echo 'selected';} echo '>Kultura</option>
                           <option value="politika" ';if($kategorija == "politika"){echo 'selected';} echo '>Politika</option>
                           <option value="zabava" ';if($kategorija == "zabava"){echo 'selected';} echo '>Zabava</option>
                       </select>
                   </div>
               </div>
               <div class="row">
                   <div class="col-25">
                       <label for="arhiva">Spremiti u arhivu</label>
                   </div>
                   <div class="col-75">
                       <input type="checkbox" name="arhiva" '.$checked.'>
                   </div>
               </div>
               
               <input type="submit" name="update"  class="button" value="Izmjeni">
               <input type="submit" name="delete" class="button" value="Izbriši">
               
           </form>';
           } ?>
        </section>
           
        <footer>
            <p>Kristijan Ribaric - LoremNews®</p>
        </footer>
    </div>
    
</body>
</html>


<?php

if(isset($_POST['delete'])){
    $id=$_POST['id'];
    include 'connect.php';
    $sql = "DELETE FROM clanak WHERE id=$id ";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        echo "Članak uspješno obrisan.";
    }
}

if(isset($_POST['update'])){
    if(!empty($_FILES["slika"]["name"])){
        $filepath = "uploads/" . $_FILES["slika"]["name"];
        move_uploaded_file($_FILES["slika"]["tmp_name"],$filepath);
    }
    else {
        $filepath = $_POST['slika_old'];
    }
    
    list($width, $height) = getimagesize($filepath);
    if($width == 1920 && $height == 1080) {
        $id = $_POST['id'];
        $slika = $filepath;
        $naslov = $_POST['naslov'];
        $kratki = $_POST['kratki'];
        $dugi = $_POST['dugi'];
        $kategorija = $_POST['kategorija'];
        $arhiva = isset($_POST['arhiva']);

        include 'connect.php';
        $sql = "UPDATE clanak SET slika='$slika',naslov='$naslov', kratki='$kratki', dugi='$dugi', kategorija='$kategorija', arhiva='$arhiva' WHERE id=? ";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt,'i',$id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);}
        echo  '<p>Članak uspješno izmjenjen.</p>';
    }
    else {
        echo  '<p>Slika mora biti dimenzija 1920x1080!</p>';
        unlink($filepath);
    }
}

?>