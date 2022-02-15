<?php
session_start();
if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, CRYPT_BLOWFISH);
    $razina = 0;
    include 'connect.php';

    $sql1 = "SELECT username from korisnik WHERE username = ?";
    $stmt1 = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt1, $sql1)){
        mysqli_stmt_bind_param($stmt1,'s',$username);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_store_result($stmt1);
    }

    if(mysqli_stmt_num_rows($stmt1) >= 1) {
        $error = "<p>Korisničko ime se već koristi</p>";
    } 
    else {
      $sql2 = "INSERT INTO korisnik (ime, prezime, username, password, razina) values (?,?,?,?,?)";
      $stmt2 = mysqli_stmt_init($dbc);
      if (mysqli_stmt_prepare($stmt2, $sql2)){
        mysqli_stmt_bind_param($stmt2,'ssssi',$ime,$prezime,$username,$password_hash,$razina);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_store_result($stmt2);
      }
      if($stmt2){
        $success = '<p>Registracija je uspješna.</p> <a class="registration_link" href="login.php">Prijavi se.</a>';
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
    <style>
        .registration-wrapper {   
           width:40%;
        }

        form {
            margin: 40px 0px;
        }

        .boja {
            color: red;
            
        }


        @media only screen and (max-width: 600px) {
            .registration-wrapper {
                width:100%;
            }

            .button {
                margin-top: 20px;
            }
        }
    </style>
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
        <main>
            <section class="registration-wrapper">

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <div class="row">
                        <div class="col-25">
                            <label for="ime">Ime</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="ime" id="ime">
                            <span id="porukaIme" class="boja"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="prezime">Prezime</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="prezime" id="prezime">
                            <span id="porukaPrezime" class="boja"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="username">Korisničko ime</label>
                        </div>
                        <div class="col-75">
                            <input type="text" name="username" id="username">
                            <span id="porukaUsername" class="boja"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="password">Lozinka</label>
                        </div>
                        <div class="col-75">
                            <input type="password" name="password" id="password">
                            <span id="porukaPassword" class="boja"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="password2">Ponovite lozinku</label>
                        </div>
                        <div class="col-75">
                            <input type="password" name="password2" id="password2">
                        </div>
                    </div>
                    <input type="submit" name="submit" id="submit" class="button" value="Registracija">
                    <h3><?php if(isset($success)){
                                echo $success;}
                            elseif(isset($error)){
                                echo $error;
                            }
                        ?>
                    </h3>
                </form>

                <script>
                    document.getElementById("submit").onclick = function(event) {
                        var slanje_forme = true;


                        var poljeIme = document.getElementById("ime");
                        var ime = document.getElementById("ime").value;
                        if (ime.length == 0) {
                            slanje_forme = false;
                            document.getElementById("porukaIme").innerHTML = "Molim unesite ime";
                            poljeIme.style.border="1px solid red";
                        }
                        else {
                            document.getElementById("porukaIme").innerHTML = "";
                            poljeIme.style.border="1px solid green";
                        }

                        var poljePrezime = document.getElementById("prezime");
                        var prezime = document.getElementById("prezime").value;
                        if (prezime.length == 0) {
                            slanje_forme = false;
                            document.getElementById("porukaPrezime").innerHTML = "Molim unesite prezime";
                            poljePrezime.style.border="1px solid red";
                        }
                        else {
                            document.getElementById("porukaPrezime").innerHTML = "";
                            poljePrezime.style.border="1px solid green";
                        }

                        var poljeUsername = document.getElementById("username");
                        var username = document.getElementById("username").value;
                        if (username.length == 0) {
                            slanje_forme = false;
                            document.getElementById("porukaUsername").innerHTML = "Molim unesite korisničko ime";
                            poljeUsername.style.border="1px solid red";
                        }
                        else {
                            document.getElementById("porukaUsername").innerHTML = "";
                            poljeUsername.style.border="1px solid green";
                        }


                        var poljePassword = document.getElementById("password");
                        var password = document.getElementById("password").value;
                        var poljePassword2 = document.getElementById("password2");
                        var password2 = document.getElementById("password2").value;
                        if (password != password2 || password.length == 0 || password2.length == 0) {
                            slanje_forme = false;
                            document.getElementById("porukaPassword").innerHTML = "Lozinke trebaju biti iste";
                            poljePassword.style.border="1px solid red";
                            poljePassword2.style.border="1px solid red";
                        }
                        else {
                            document.getElementById("porukaPassword").innerHTML = "";
                            poljePassword.style.border="1px solid green";
                            poljePassword2.style.border="1px solid green";
                        }


                        if (slanje_forme != true) {
                            event.preventDefault();
                        }

                    }
                </script>

            </section>
        </main>
        

        <footer>
            <p>Kristijan Ribaric - LoremNews®</p>
        </footer>
    </div>
    
</body>
</html>