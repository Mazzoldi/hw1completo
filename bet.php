<?php
    require_once 'auth.php';
    session_start();
    if (!checkAuth()) {
        header("Location: login.php");
        exit;
    }
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
        $favourites[] = $row['team_id'];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            let user_id = <?php echo $userid?>;
            let numbets = <?php echo $numbets?>;
        </script>
        <script src="bet.js" defer></script>
        <link rel="stylesheet" href="bet.css">
        <title>Scommesse - <?php echo $userinfo['name']." ".$userinfo['surname']?></title>
    </head>
    <body>
        <header>
            <nav>
                <div class="nav-container">
                    <a id='logo' href="home.php">Footbet.news</a>
                    <div id="links">
                        <a href="home.php">Home</a>
                        <a href="favourites.php">Squadre</a>
                        <a href="profile.php">Profilo</a>
                        <div id="separator"></div>
                        <a href="logout.php" class="button">LOGOUT</a>
                    </div>
                    <div id="menu">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
                <div class="sidebar">
                    <div class="info">
                        <div class="avatar" style="background-image: url(<?php echo $userinfo['file_path'] == null ? "assets/default_avatar.png" : $userinfo['file_path']?>)"></div>
                        <div class="tag">
                            <a href="modifica_profilo.php"><h1><?php echo $userinfo['name']." ".$userinfo['surname']?></h1></a>
                            <h2><?php echo "@".$userinfo['username']?></h2>
                        </div>
                    </div>
                    <div class="stat">
                        <a href="favourites.php"><h1>Favourites</h1></a>
                        <h2><?php echo $numfavourites ?></h2>
                    </div>
                    <div class="stat">
                        <a href="bet.php"><h1>Bets</h1></a>
                        <h2><?php echo $numbets ?></h2>
                    </div>
                </div>
            </nav>
        </header>
        <section class="container">
            <section class="matches"></section>
            <section class="hidden" id="bet"></section>
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