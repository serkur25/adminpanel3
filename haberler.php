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

$sql = "SELECT * FROM haberler";
$result = $conn->query($sql);

$haberler = [];
while ($row = $result->fetch_assoc()) {
    $haberler[] = $row;
}

echo json_encode($haberler);

$conn->close();
?>