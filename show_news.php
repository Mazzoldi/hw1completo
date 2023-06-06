<?php
    require_once 'auth.php';
    session_start();
    if(checkAuth()){
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $userid = mysqli_real_escape_string($conn, $_SESSION['username']);
        $query = "SELECT * FROM users WHERE username = '".$userid."'";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);
    } else{
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script> let query = "<?php echo $_GET["q"]?>";</script>
        <script src="show_news.js" defer></script>
        <link rel="stylesheet" href="show_news.css">
        <title>Football.bet</title>
    </head>
    <body>
        <header>
            <nav>
                <div class='nav-container'>
                    <a id='logo' href="home.php">Footbet.news</a>
                    <div id="links">
                        <a href='home.php'>Home</a>
                        <a href="favourites.php">Squadre</a>
                        <a href="bet.php">Scommesse</a>
                        <div id="separator"></div>
                        <?php if(!isset($_SESSION["username"])){
                            echo "<a href='login.php'>Login</a>";
                            echo "<a href='signup.php'>Registrati</a>";
                        }
                        else{
                            echo "<a id='profilo' href='profile.php'><img id='logo_profilo' src=".($userinfo['file_path'] == null ? "assets/default_avatar.png" : $userinfo['file_path'])."></a>";
                            echo "<a href='logout.php' class='button'>Logout</a>";
                        }?>
                    </div>
                    <div id="menu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </nav>
        </header>
        <section id="search">
            <form method="get" autocomplete="off">
                <div class="search">
                    <input type="text" id="input_search" name="barra_ricerca" placeholder="Cerca notizie">
                    <input type="submit" id="submit" value="Cerca">
                </div>
            </form>
        </section>
        <section class="container">
            <h1 id="query"></h1>
            <div id="results"></div>
        </section>
        <footer>
            <nav id="footer">
                <p>Chi siamo?</p>
                <p>Contatti</p>
                <p>FAQ</p>
                <p>Privacy policy</p>
                <p>Cookie policy</p>
            </nav>
        </footer>
    </body>
</html>
<?php mysqli_close($conn);?>