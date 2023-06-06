<?php
    require_once 'auth.php';
    if (!checkAuth()) {
        header("Location: login.php");
        exit;
    }
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $userid = mysqli_real_escape_string($conn, $_SESSION['username']);
    $query = "SELECT * FROM users WHERE username = '".$userid."'";
    $res_1 = mysqli_query($conn, $query);
    $userinfo = mysqli_fetch_assoc($res_1);
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["name"]) && !empty($_POST["surname"])){
        $error = array();
        if (!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['name'])) {
            $error[] = "Nome non valido";
        } else {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
        }
        if (!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['surname'])) {
            $error[] = "Cognome non valido";
        } else {
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
        }
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else if ($_POST['username'] !== $_SESSION['username']){
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        } else{
            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $password = password_hash($password, PASSWORD_BCRYPT);
        }
        if (count($error) == 0) { 
            if ($_FILES['avatar']['size'] != 0) {
                $file = $_FILES['avatar'];
                $type = exif_imagetype($file['tmp_name']);
                $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif');
                if (isset($allowedExt[$type])) {
                    if ($file['error'] === 0) {
                        if ($file['size'] < 7000000) {
                            $fileNameNew = uniqid('', true).".".$allowedExt[$type];
                            $fileDestination = 'assets/'.$fileNameNew;
                            move_uploaded_file($file['tmp_name'], $fileDestination);
                        } else {
                            $error[] = "L'immagine non deve avere dimensioni maggiori di 7MB";
                        }
                    } else {
                        $error[] = "Errore nel carimento del file";
                    }
                } else {
                    $error[] = "I formati consentiti sono .png, .jpeg, .jpg e .gif";
                }
            }else{
                echo "Non hai caricato nessuna immagine";
            }
        }
        if ((count($error) === 0) && (password_verify($_POST['password'], $userinfo['password']))){
            $query = "UPDATE users SET name = '".$_POST['name']."', surname = '".$_POST['surname']."', username = '".$_POST['username']."' WHERE username = '".$_SESSION["username"]."'";
            if($fileDestination !== null){
                $query = "UPDATE users SET file_path = '".$fileDestination."' WHERE username = '".$_SESSION["username"]."'";
            }
            if (mysqli_query($conn, $query)) {
                $_SESSION["username"] = $_POST["username"];
                mysqli_close($conn);
                header("Location: profile.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }
        mysqli_close($conn);
    }
    else if (isset($_POST["username"]) || isset($_POST["password"])|| isset($_POST["name"]) || isset($_POST["surname"])){
        $error = array("Riempi tutti i campi");
    }
?>
<html>
    <?php
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $userid = mysqli_real_escape_string($conn, $_SESSION['username']);
        $query = "SELECT * FROM users WHERE username = '".$userid."'";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);
    ?>
    <head>
        <link rel="stylesheet" href="modifica_profilo.css">
        <script src="modifica_profilo.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
        <title>Footbet.news - <?php echo $userinfo['name']." ".$userinfo['surname']?></title>
    </head>
    <body>
        <header>
            <nav>
                <div class="nav-container">
                    <a id="logo" href="home.php">Footbet.news</a>
                    <div id="links">
                        <a href="profile.php">Profilo</a>
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
            </nav>
        </header>
        <section class="container">
            <h1>Modifica le info del tuo profilo, inserisci la password per confermare</h1>
            <div class="avatar"><div class="avatar_interno" style="background-image: url(<?php echo $userinfo['file_path'] == null ? "assets/default_avatar.png" : $userinfo['file_path']?>)"></div><img src="assets/edit.png" id="icona_modifica"></div>
            <form name='signup' id='form' method='post' enctype="multipart/form-data" autocomplete="off">
                <div class="names">
                    <div class="name">
                        <label for='name'>Nome</label>
                        <input type='text' name='name' placeholder='Nome' <?php echo "value=".$userinfo["name"];?>>
                        <div><img src="assets/close.svg"/><span>Devi inserire il tuo nome</span></div>
                    </div>
                    <div class="surname">
                        <label for='surname'>Cognome</label>
                        <input type='text' name='surname' placeholder='Cognome' <?php echo "value=".$userinfo["surname"];?>>
                        <div><img src="assets/close.svg"/><span>Devi inserire il tuo cognome</span></div>
                    </div>
                </div>
                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' name='username' placeholder='Username' <?php echo "value=".$userinfo["username"];?>>
                    <div><img src="assets/close.svg"/><span>Nome utente non disponibile</span></div>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' placeholder='Password'>
                    <div><img src="assets/close.svg"/><span>Inserisci almeno 8 caratteri</span></div>
                </div>
                <div class="hidden" id="fileupload">
                    <label for='avatar'>Scegli un'immagine profilo</label>
                        <input type='file' name='avatar' accept='.jpg, .jpeg, image/gif, image/png' id="upload_original" value="">
                        <div id="upload"><div class="file_name">Seleziona un file...</div><div class="file_size"></div></div>
                    <span>Le dimensioni del file superano 7 MB</span>
                </div>
                <?php if(isset($error)) {
                    foreach($error as $err) {
                        echo "<div class='errorj'><img src='./assets/close.svg'/><span>".$err."</span></div>";
                    }
                }?>
                <div class="submit">
                    <input type='submit' value="Conferma" id="submit">
                </div>
            </form>
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