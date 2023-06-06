<?php
    require_once 'auth.php';
    session_start();
    if (!checkAuth()) exit;
    header('Content-Type: application/json');
    $api_key="763e4690a62f4877a2096b7a35933b95";
    $url = "https://api.football-data.org/v4/matches?competitions=SA,FL1,PD,PL,BL1&dateFrom=2023-06-01&dateTo=2023-06-05";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$api_key));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $res = curl_exec($ch);
    curl_close($ch);
    echo $res;
?>