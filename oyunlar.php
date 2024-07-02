<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oyun_incelemeleri";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$sql = "SELECT * FROM oyunlar";
$result = $conn->query($sql);

$oyunlar = [];
while ($row = $result->fetch_assoc()) {
    $oyunlar[] = $row;
}

echo json_encode($oyunlar);

$conn->close();
?>