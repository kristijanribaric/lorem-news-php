<?php
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['razina'])) {
    header("Location:administracija.php");
}


if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    include 'connect.php';

    $sql = "SELECT ime,username,password,razina from korisnik WHERE username = ? LIMIT 1";
       
       
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt,'s',$username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $ime,$username, $password,$razina);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_fetch($stmt);
        
    }

    if(mysqli_stmt_num_rows($stmt)>0 && password_verify($pass, $password) && $username == $username){
        $_SESSION['ime'] = $ime;
        $_SESSION['username'] = $username;
        $_SESSION['razina'] = $razina;
        header("Location:administracija.php");
        exit();
    }
    else  {
        $error = "<h3>Unijeli ste pogrešno korisničko ime ili lozinku</h3>";

    }   


}

if(isset($_GET['logout']) && $_GET['logout'] == 1){
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["razina"]);
    header("Location:index.php");
    exit();
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
                    <input type="submit" name="submit" id="submit" class="button" value="Prijava">
                    Nemaš račun? <a href="registration.php" class="registration_link">Registriraj se</a>
                    <?php if(isset($error)){
                    echo $error;} ?>
                </form>

                <script>
                    document.getElementById("submit").onclick = function(event) {
                        var slanje_forme = true;


                       

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
                        if (password.length == 0) {
                            slanje_forme = false;
                            document.getElementById("porukaPassword").innerHTML = "Molim unesite lozinku";
                            poljePassword.style.border="1px solid red";
                        }
                        else {
                            document.getElementById("porukaPassword").innerHTML = "";
                            poljePassword.style.border="1px solid green";
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