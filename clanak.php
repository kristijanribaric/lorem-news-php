<?php
session_start();
$a = $_GET['id'];
include 'connect.php';
$sql = 'SELECT id,naslov,kratki,slika,dugi,kategorija from clanak WHERE id = ?';
$stmt = mysqli_stmt_init($dbc);
if (mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt,'s',$a);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $id, $naslov,$kratki,$slika,$dugi,$kategorija);
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
                <a href="administracija.php">Administracija</a>
            </nav>
        </header>
        
        <section>

            <?php if(mysqli_stmt_num_rows($stmt)>0){
                    while ($row = mysqli_stmt_fetch($stmt)) {
                    echo ' <h2>'. $naslov.'</h2>
                    <h3>'.$kratki. '</h3>
                    <img src="'.$slika.'" width = 100%>
                    <p>'. $dugi.'</p>';
                }}
            ?>
            
            
        </section>

        <footer>
            <p>Kristijan Ribaric - LoremNews®</p>
        </footer>
    </div>
    
</body>
</html>