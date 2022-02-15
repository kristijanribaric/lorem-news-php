<?php
session_start();
include 'connect.php';

$sql = 'SELECT id,naslov,kratki,slika,kategorija,arhiva from clanak WHERE kategorija = "sport" OR kategorija = "kultura";';
$stmt = mysqli_stmt_init($dbc);
if (mysqli_stmt_prepare($stmt, $sql)){
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  mysqli_stmt_bind_result($stmt, $id, $naslov,$kratki,$slika,$kategorija,$arhiva);
}

$sport_array = array();
$kultura_array = array();
if(mysqli_stmt_num_rows($stmt) > 0) {
    while($row= mysqli_stmt_fetch($stmt)){
        $record = array();
        if($kategorija == "sport" && $arhiva == 0) {
            $record['id'] = $id;
            $record['naslov'] = $naslov;
            $record['kratki'] = $kratki;
            $record['slika'] = $slika;
            array_push($sport_array,$record);
        }
        else if($kategorija == "kultura" && $arhiva == 0){
            $record['id'] = $id;
            $record['naslov'] = $naslov;
            $record['kratki'] = $kratki;
            $record['slika'] = $slika;
            array_push($kultura_array,$record);
        }
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
                <a class="active" href="index.php">Početna</a>
                <a href="kategorija.php?id=sport">Sport</a>
                <a href="kategorija.php?id=kultura">Kultura</a>
                <a href="kategorija.php?id=politika">Politika</a>
                <a href="kategorija.php?id=zabava">Zabava</a>
                <a href="unos.php">Predaj članak</a>
                <a href="login.php">Administracija</a>
            </nav>
            
            
        </header>
        
        <main>
            <section>
                <a href="kategorija.php?id=sport"><h2>Sport ></h2></a>
                <div class="articles">
                    <a href="clanak.php?id=<?php if(isset($sport_array[0])){echo $sport_array[0]['id'];} ?>">
                        <article>
                            <img src="<?php if(isset($sport_array[0])){echo $sport_array[0]['slika'];}?>" >
                            <h3><?php if(isset($sport_array[0])){echo $sport_array[0]['naslov'];} ?></h3>
                            <p><?php if(isset($sport_array[0])){echo $sport_array[0]['kratki'];} ?></p>
                        </article>
                    </a>
                    
                    <a href="clanak.php?id=<?php if(isset($sport_array[1])){echo $sport_array[1]['id'];} ?>">
                        <article>
                            <img src="<?php if(isset($sport_array[1])){echo $sport_array[1]['slika'];}?>">
                            <h3><?php if(isset($sport_array[1])){echo $sport_array[1]['naslov'];}?></h3>
                            <p><?php if(isset($sport_array[1])){echo $sport_array[1]['kratki'];}?></p>
                        </article>
                    </a>
                    
                    <a href="clanak.php?id=<?php if(isset($sport_array[2])){echo $sport_array[2]['id'];} ?>">
                        <article>
                            <img src="<?php if(isset($sport_array[2])){echo $sport_array[2]['slika'];}?>">
                            <h3><?php if(isset($sport_array[2])){echo $sport_array[2]['naslov'];} ?></h3>
                            <p><?php if(isset($sport_array[2])){echo $sport_array[2]['kratki'];} ?></p>
                        </article>
                    </a>
                    
                </div>
            </section>


            <section>
                <a href="kategorija.php?id=kultura"><h2>Kultura ></h2></a>
                <div class="articles">
                    <a href="clanak.php?id=<?php if(isset($kultura_array[0])){echo $kultura_array[0]['id'];} ?>">
                        <article>
                            <img src="<?php if(isset($kultura_array[0])){echo $kultura_array[0]['slika'];}?>">
                            <h3><?php if(isset($kultura_array[0])){echo $kultura_array[0]['naslov'];}?></h3>
                            <p><?php if(isset($kultura_array[0])){echo $kultura_array[0]['kratki'];} ?></p>
                        </article>
                        </article>
                    </a>
                    
                    <a href="clanak.php?id=<?php if(isset($kultura_array[1])){echo $kultura_array[1]['id'];} ?>">
                        <article>
                            <img src="<?php if(isset($kultura_array[1])){echo $kultura_array[1]['slika'];}?>">
                            <h3><?php if(isset($kultura_array[1])){echo $kultura_array[1]['naslov'];} ?></h3>
                            <p><?php if(isset($kultura_array[1])){echo $kultura_array[1]['kratki'];} ?></p>
                        </article>
                    </a>
                    
                    <a href="clanak.php?id=<?php if(isset($kultura_array[2])){echo $kultura_array[2]['id'];} ?>">
                        <article >
                            <img src="<?php if(isset($kultura_array[2])){echo $kultura_array[2]['slika'];}?>">
                            <h3><?php if(isset($kultura_array[2])){echo $kultura_array[2]['naslov'];}?></h3>
                            <p><?php if(isset($kultura_array[2])){echo $kultura_array[2]['kratki'];} ?></p>
                        </article>
                    </a>
                    
                </div>
            </section>
        </main>
        <footer>
            <p>Kristijan Ribaric - LoremNews®</p>
        </footer>
    </div>
    
</body>
</html>