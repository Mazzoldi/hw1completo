<?php
    require_once 'auth.php';
    session_start();
    if (!checkAuth()) exit;
    header('Content-Type: application/json');
    $api_key="4dc6a19c0c164d089996293f208394a6";
    $query = urlencode($_GET["q"]);
    $url = "https://newsapi.org/v2/everything?q=".$query."&searchIn=title&language=it&sortBy=publishedAt&pageSize=20&apiKey=".$api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $res = curl_exec($ch);
    curl_close($ch);
    echo $res;
?>