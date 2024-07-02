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

$gorsel_url = $_POST['gorsel_url'];
$baslik = $_POST['baslik'];
$aciklama = $_POST['aciklama'];

$sql = "INSERT INTO haberler (gorsel_url, baslik, aciklama) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $gorsel_url, $baslik, $aciklama);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Haber eklenemedi."]);
}

$stmt->close();
$conn->close();
?>