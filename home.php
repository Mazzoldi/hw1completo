<?php
    require_once 'auth.php';
    session_start();
    if(!checkAuth()){
        header('location:login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query1 = "SELECT * FROM users WHERE username = '".$username."'";
    $res_1 = mysqli_query($conn, $query1);
    $userinfo = mysqli_fetch_assoc($res_1);
    $userid = $userinfo['user_id'];
    $query2 = "SELECT COUNT(*) FROM favourites WHERE user_id = '".$userid."'";
    $res_2 = mysqli_query($conn, $query2);
    $numfavourites = mysqli_fetch_assoc($res_2)['COUNT(*)'];
    $query3 = "SELECT COUNT(*) FROM bets WHERE user_id = '".$userid."'";
    $res_3 = mysqli_query($conn, $query3);
    $numbets = mysqli_fetch_assoc($res_3)['COUNT(*)'];
    $query4 = "SELECT team_id FROM favourites WHERE user_id = '".$userid."'";
    $res_4 = mysqli_query($conn, $query4);
    $favourites = array();
    while($row = mysqli_fetch_assoc($res_4)){
        $query5 = "SELECT name FROM teams WHERE team_id = '".$row['team_id']."'";
        $res_5 = mysqli_query($conn, $query5);
        $team = mysqli_fetch_assoc($res_5)['name'];
        $favourites[] = $team;
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script>let favourites = <?php echo json_encode($favourites)?>;</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="home.js" defer></script>
    <link rel="stylesheet" href="home.css">
    <title>Football.bet</title>
</head>
    <body>
        <header>
            <nav>
                <div class="nav-container">
                    <a id='logo' href="home.php">Footbet.news</a>
                    <div id="links">
                        <section id="search">
                            <form method="get" autocomplete="off">
                                <div class="search">
                                    <input type="text" id="input_search" name="barra_ricerca" placeholder="Cerca notizie">
                                    <input type="submit" id="submit" value="Cerca">
                                </div>
                            </form>
                        </section>
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
            <div id="copertina">
                <h1 id="title">Footbet.news, il tuo sito calcistico preferito</h1>
                <a id="subtitle">Con Footbet.news puoi trovare le informazioni calcistiche che hai sempre cercato</a>
            </div>
        </header>
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