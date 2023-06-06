<?php
    require_once 'auth.php';
    session_start();
    if (!checkAuth()) exit;
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));  
    $id = mysqli_real_escape_string($conn, $_POST['team_id']);
    $name = mysqli_real_escape_string($conn, $_POST['team_name']);
    $short_name = mysqli_real_escape_string($conn, $_POST['team_short_name']);
    $logo_file_path = mysqli_real_escape_string($conn, $_POST['team_logo_file_path']);
    $competition_code = mysqli_real_escape_string($conn, $_POST['team_competition_code']);
    $competition_name = mysqli_real_escape_string($conn, $_POST['team_competition_name']);
    $query = "INSERT INTO teams(team_id, name, short_name, logo_filepath, competition_code, competition_name) VALUES ('$id', '$name', '$short_name', '$logo_file_path', '$competition_code', '$competition_name')";
    $res = mysqli_query($conn, $query);
    mysqli_close($conn);
?>