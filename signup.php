<?php
    require_once 'auth.php';
    if (checkAuth()) {
        header("Location: home.php");
        exit;
    }
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["name"]) && 
        !empty($_POST["surname"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"]) && !empty($_POST["day"]) && !empty($_POST["month"]) && !empty($_POST["year"])){
        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
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
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        }
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
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
        if (count($error) == 0) {
            $date = $_POST['day']."-".$_POST['month']."-".$_POST['year'];
            $date = date('Y-m-d', strtotime($date));
            $_POST['date'] = mysqli_real_escape_string($conn, $date);
        }
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users(username, name, surname, password, email, birthday, file_path) VALUES('$username', '$name', '$surname', '$password', '$email', '$date','$fileDestination')";
            if (mysqli_query($conn, $query)) {
                $_SESSION["username"] = $_POST["username"];
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }
        mysqli_close($conn);
    }
    else if (isset($_POST["username"]) || isset($_POST["password"]) || isset($_POST["email"]) || isset($_POST["name"]) || 
            isset($_POST["surname"]) || isset($_POST["confirm_password"]) || isset($_POST["allow"])){
        $error = array("Riempi tutti i campi");
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='signup.css'>
        <script src='signup.js' defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Iscriviti - Footbet.news</title>
    </head>
    <body>
        <div id="logo">Footbet.news</div>
        <main>
        <section class="main_left">
        </section>
        <section class="main_right">
            <h1>Iscriviti gratuitamente per vivere la migliore esperienza sportiva a 360°</h1>
            <form name='signup' id='form' method='post' enctype="multipart/form-data" autocomplete="off">
                <div class="names">
                    <div class="name">
                        <label for='name'>Nome</label>
                        <input type='text' name='name' placeholder='Nome' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> >
                        <div><img src="./assets/close.svg"/><span>Devi inserire il tuo nome</span></div>
                    </div>
                    <div class="surname">
                        <label for='surname'>Cognome</label>
                        <input type='text' name='surname' placeholder='Cognome' <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> >
                        <div><img src="./assets/close.svg"/><span>Devi inserire il tuo cognome</span></div>
                    </div>
                </div>
                <div class="username">
                    <label for='username'>Username</label>
                    <input type='text' name='username' placeholder='Username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                    <div><img src="./assets/close.svg"/><span>Nome utente non disponibile</span></div>
                </div>
                <div class="birthday">
                    <label for='birthday'>Data di nascita</label>
                    <div class="birthday_container">
                        <select name="day" id="day" form="form" <?php if(isset($_POST["day"])){echo "value=".$_POST["day"];}?>>
                            <option value="" disabled selected>Giorno</option>
                            <?php
                                for($i=1; $i<=31; $i++){
                                    echo "<option value=".$i.">".$i."</option>";
                                }
                            ?>
                        </select>
                        <select name="month" id="month" form="form">
                            <option value="" disabled selected>Mese</option>
                            <?php
                                for($i=1; $i<=12; $i++){
                                    if($i<10){
                                        echo "<option value=0".$i.">0".$i."</option>";
                                    } else{
                                        echo "<option value=".$i.">".$i."</option>";
                                    }
                                }
                            ?>
                        </select>
                        <select name="year" id="year" form="form" <?php if(isset($_POST["year"])){echo "value=".$_POST["year"];}?>>
                            <option value="" disabled selected>Anno</option>
                            <?php
                                for($i=2022; $i>=1900; $i--){
                                    echo "<option value=".$i.">".$i."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div><img src="./assets/close.svg"/><span>Inserisci una data</span></div>
                </div>
                <div class="email">
                    <label for='email'>Email</label>
                    <input type='text' name='email' placeholder='Email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];}?>>
                    <div><img src="./assets/close.svg"/><span>Indirizzo email non valido</span></div>
                </div>
                <div class="password">
                    <label for='password'>Password</label>
                    <input type='password' name='password' placeholder='Password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                    <div><img src="./assets/close.svg"/><span>Inserisci almeno 8 caratteri</span></div>
                </div>
                <div class="confirm_password">
                    <label for='confirm_password'>Conferma Password</label>
                    <input type='password' name='confirm_password' placeholder='Conferma password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                    <div><img src="./assets/close.svg"/><span>Le password non coincidono</span></div>
                </div>
                <div class="fileupload">
                    <label for='avatar'>Scegli un'immagine profilo</label>
                        <input type='file' name='avatar' accept='.jpg, .jpeg, image/gif, image/png' id="upload_original">
                        <div id="upload"><div class="file_name">Seleziona un file...</div><div class="file_size"></div></div>
                    <span>Le dimensioni del file superano 7 MB</span>
                </div>
                <div class="allow"> 
                    <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>>
                    <label for='allow'>Accetto i termini e condizioni d'uso di Footbet.news.</label>
                </div>
                <?php if(isset($error)) {
                    foreach($error as $err) {
                        echo "<div class='errorj'><img src='./assets/close.svg'/><span>".$err."</span></div>";
                    }
                }?>
                <div class="submit">
                    <input type='submit' value="Registrati" id="submit">
                </div>
            </form>
            <div class="signup">Hai un account? <a href="login.php">Accedi</a>
        </section>
        </main>
    </body>
</html>