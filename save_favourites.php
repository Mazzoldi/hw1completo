<?php
    require_once 'auth.php';
    session_start();
    if (!checkAuth()) exit;
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $team_name = mysqli_real_escape_string($conn, $_POST['team_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $query = "SELECT user_id FROM users WHERE username = '$username'";
    $res = mysqli_query($conn, $query);
    $user_id = mysqli_fetch_assoc($res)['user_id'];
    $query = "SELECT team_id FROM teams WHERE name = '$team_name'";
    $res = mysqli_query($conn, $query);
    $team_id = mysqli_fetch_assoc($res)['team_id'];
    $query = "INSERT INTO favourites(user_id, team_id) VALUES ('$user_id', '$team_id')";
    $res = mysqli_query($conn, $query);
    mysqli_close($conn);
    echo $res;
?>