<?php
session_start();
if (!empty($_POST['naslov']) && !empty($_POST['kratki'])
    && !empty($_POST['dugi']) && !empty($_POST['kategorija'])) {
    $filepath = "uploads/" . $_FILES["slika"]["name"];
    move_uploaded_file($_FILES["slika"]["tmp_name"],$filepath);
    list($width, $height) = getimagesize($filepath);
    if($width == 1920 && $height == 1080) {
        $slika = $filepath;
        $naslov = $_POST['naslov'];
        $kratki = $_POST['kratki'];
        $dugi = $_POST['dugi'];
        $kategorija = $_POST['kategorija'];
        $arhiva = isset($_POST['arhiva']);

        include 'connect.php';
        $sql = "INSERT INTO clanak (naslov, kratki, dugi, slika, kategorija, arhiva) values (?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt,'sssssi',$naslov, $kratki, $dugi, $slika, $kategorija, $arhiva);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);}
  
    }
    else {
        $error = "Slika mora biti dimenzija 1920x1080!";
        unlink($filepath);
    }

    
}
else {
    $error = "Niste ispunili sva polja!";
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
                <a  href="index.php">Početna</a>
                <a href="kategorija.php?id=sport">Sport</a>
                <a href="kategorija.php?id=kultura">Kultura</a>
                <a href="kategorija.php?id=politika">Politika</a>
                <a href="kategorija.php?id=zabava">Zabava</a>
                <a class="active" href="unos.php">Predaj članak</a>
                <a href="administracija.php">Administracija</a>
            </nav>
        </header>
        <section>
            <?php if(isset($error)) {echo $error; echo '<br><br><a class="button" href="unos.html">Vrati se na formu</a>';} ?>
            <h2><?php if(isset($naslov)){echo $naslov;} ?></h2>
            <h3><?php if(isset($kratki)){echo $kratki;} ?></h3>
            <?php if(isset($slika)){echo '<img src="'.$slika.'" alt="picture" width = 100%>';}?>
            
            <p><?php if(isset($dugi)){echo $dugi;} ?></p>
        </section>
        
        <footer>
            <p>Kristijan Ribaric - LoremNews®</p>
        </footer>
    </div>
    
</body>
</html>