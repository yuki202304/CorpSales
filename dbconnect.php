<?php
$url = parse_url(getenv("JAWSDB_URL"));
$hostname = $url['host'];
$username = $url['user'];
$password = $url['pass'];
$database = ltrim($url['path'],'/');
try {
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
} catch (PDOException $e) {
    echo 'DB接続エラー： ' . $e->getMessage();
}
?>
