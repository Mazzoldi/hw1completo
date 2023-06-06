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
    $query5 = "SELECT bet_id FROM bets WHERE user_id = '".$userid."'";
    $res_5 = mysqli_query($conn, $query5);
    $bets = array();
    while($row = mysqli_fetch_assoc($res_5)){
        $bets[] = $row['bet_id'];
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="profile.css">
        <script src="profile.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Footbet.news - <?php echo $userinfo['name']." ".$userinfo['surname']?></title>
    </head>
    <body>
        <header>
            <nav>
                <div class="nav-container">
                    <a id='logo' href="home.php">Footbet.news</a>
                    <div id="links">
                        <a href="home.php">Home</a>
                        <a href="favourites.php">Squadre</a>
                        <a href="bet.php">Scommesse</a>
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
            <div class="favourites-wrapper-wrapper">
                <p>Le tue squadre preferite:</p>
                <div class="favourites-wrapper">
                    <ul class="favourites">
                        <div class="list">
                            <div <?php if(empty($favourites)) echo "class='hidden'";?>><?php
                                if(!empty($favourites)){
                                    $teams = array();
                                    foreach($favourites as $favourite){
                                        $query = "SELECT name, logo_filepath FROM teams WHERE team_id = '".$favourite."'";
                                        $res = mysqli_query($conn, $query);
                                        $row = mysqli_fetch_assoc($res);
                                        $teams[] = $row;
                                    }
                                    asort($teams);
                                    foreach($teams as $team){
                                        echo "<li><img src='".$team['logo_filepath']."'><span>".$team['name']."</span></li>";
                                    }
                                }
                            ?>
                            </div>
                        </div>
                        <p id='noresults' <?php if(!empty($favourites)){echo "class='hidden'";}?>>Non hai ancora aggiunto nessuna squadra ai preferiti</p>
                    </ul>
                </div>
            </div>
            <div class="bets-wrapper-wrapper">
                <p>Le tue schedine:</p>
                <div class="bets-wrapper">
                    <ul class="bets">
                        <div class="list"><?php
                            if(!empty($bets)){
                                echo "<div>";
                                $stakes = array();
                                foreach($bets as $bet){
                                    $query = "SELECT win, date_bet, details FROM bets WHERE bet_id = '".$bet."'";
                                    $res = mysqli_query($conn, $query);
                                    $row = mysqli_fetch_assoc($res);
                                    $stakes[] = $row;
                                }
                                asort($stakes);
                                foreach($stakes as $stake){
                                    echo "<li class='matches'>Vincita potenziale: €".$stake['win']." - ".$stake['date_bet']."</li>";
                                    echo "<ul class='hidden'>";
                                    $details = json_decode($stake['details'], true);
                                    $details = array_slice($details, 0, -1);
                                    foreach($details as $detail){
                                        echo "<li>".$detail['home_team']." - ".$detail['away_team']."<br>Esito: ".$detail['bet']." - Quota: ".$detail['odd']."</li>";
                                    }
                                    echo "</ul>";
                                }
                                echo "</div>";
                            }
                        ?>
                        </div>
                        <p id='noresults' <?php if(!empty($bets)){echo "class='hidden'";} ?>>Non hai ancora giocato nessuna schedina</p>
                    </ul>
                </div>
            </div>
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