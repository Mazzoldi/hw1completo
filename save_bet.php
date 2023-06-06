<?php
    require_once 'auth.php';
    session_start();
    if (!checkAuth()) exit;
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));  
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $win = mysqli_real_escape_string($conn, $_POST['win']);
    $date_bet = mysqli_real_escape_string($conn, $_POST['date_bet']);
    $date_bet = date('Y-m-d', strtotime($date_bet));
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $query = "INSERT INTO bets(user_id, win, date_bet, details) VALUES ('$user_id', '$win', '$date_bet', '$details')";
    $res = mysqli_query($conn, $query);
    mysqli_close($conn);
    echo $res;
?>