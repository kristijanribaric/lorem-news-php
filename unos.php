<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lorem News</title>
    <link rel="icon" href="img/news_logo.png" type="image/gif" sizes="16x16">
    <style>
        .boja {
            color: red;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="account">
            <?php session_start(); if(isset($_SESSION['username'])){
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
        <form method="POST" action="skripta.php" enctype="multipart/form-data" name="forma">

            <div class="row">
                <div class="col-25">
                    <label for="naslov">Naslov</label>
                </div>
                <div class="col-75">
                    <input type="text" name="naslov" id="naslov">
                    <span id="porukaNaslov" class="boja"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="kratki">Kratki sadržaj vijesti (do 50 znakova)</label>
                </div>
                <div class="col-75">
                    <textarea name="kratki" id="kratki"  cols="40" rows="6"></textarea>
                    <span id="porukaKratki" class="boja"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="dugi">Sadržaj vijesti</label>
                </div>
                <div class="col-75">
                    <textarea name="dugi" id="dugi" cols="80" rows="14"></textarea>
                    <span id="porukaDugi" class="boja"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="slika">Slika</label>
                </div>
                <div class="col-75">
                    <input type="file" name="slika" id="slika">
                    <span id="porukaSlika" class="boja"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="kategorija">Kategorija</label>
                </div>
                <div class="col-75">
                    <select name="kategorija" id="kategorija">
                        <option value="" disabled selected>Odaberi</option>
                        <option value="sport">Sport</option>
                        <option value="kultura">Kultura</option>
                        <option value="politika">Politika</option>
                        <option value="zabava">Zabava</option>
                    </select>
                    <span id="porukaKategorija" class="boja"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="arhiva">Spremiti u arhivu</label>
                </div>
                <div class="col-75">
                    <input type="checkbox" name="arhiva">
                </div>
            </div>
            
            <input type="reset" class="button" value="Poništi">
            <input type="submit" name="submit" id="submit" class="button" value="Prihvati">
            
        </form>

        <script>
            document.getElementById("submit").onclick = function(event) {
            var slanje_forme = true;
        
        
            var poljeNaslov = document.getElementById("naslov");
            var naslov = document.getElementById("naslov").value;
            if (naslov.length < 5 || naslov.length > 30) {
                slanje_forme = false;
                document.getElementById("porukaNaslov").innerHTML = "Naslov ne smije biti manji od 5 niti veći od 30 znakova.";
                poljeNaslov.style.border="1px solid red";
            }
            else {
                document.getElementById("porukaNaslov").innerHTML = "";
                poljeNaslov.style.border="1px solid green";
            }

            var poljeKratki = document.getElementById("kratki");
            var kratki = document.getElementById("kratki").value;
            if (kratki.length < 10 || kratki.length > 100) {
                slanje_forme = false;
                document.getElementById("porukaKratki").innerHTML = "Kratki sadržaj ne smije biti manji od 10 niti veći od 100 znakova.";
                poljeKratki.style.border="1px solid red";
            }
            else {
                document.getElementById("porukaKratki").innerHTML = "";
                poljeKratki.style.border="1px solid green";
            }

            var poljeDugi = document.getElementById("dugi");
            var dugi = document.getElementById("dugi").value;
            if (dugi.length < 1) {
                slanje_forme = false;
                document.getElementById("porukaDugi").innerHTML = "Sadržaj ne smije biti prazan.";
                poljeDugi.style.border="1px solid red";
            }
            else {
                document.getElementById("porukaDugi").innerHTML = "";
                poljeDugi.style.border="1px solid green";
            }

            var poljeSlika = document.getElementById("slika");
            var slika = document.getElementById("slika").value;
            if (slika.length == 0) {
                slanje_forme = false;
                document.getElementById("porukaSlika").innerHTML = "Slika nije odabrana.";
                
            }
            else {
                document.getElementById("porukaSlika").innerHTML = " ✔ ";
                document.getElementById("porukaSlika").style.color = "green"
            }
            
            var poljeKategorija = document.getElementById("kategorija");
            var kategorija = document.getElementById("kategorija").selectedIndex;
            if (kategorija == 0) {
                slanje_forme = false;
                document.getElementById("porukaKategorija").innerHTML = "Kategorija mora biti odabrana.";
                poljeKategorija.style.border="1px solid red";
            }
            else {
                document.getElementById("porukaKategorija").innerHTML = "";
                poljeKategorija.style.border="1px solid green";
            }

            if (slanje_forme != true) {
                event.preventDefault();
            }

          
            }
        </script>
        
        <footer>
            <p>Kristijan Ribaric - LoremNews®</p>
        </footer>
    </div>
    
</body>
</html>