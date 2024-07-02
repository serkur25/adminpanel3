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

$resim_url = $_POST['resim_url'];
$baslik = $_POST['baslik'];
$aciklama = $_POST['aciklama'];
$detayli_aciklama = $_POST['detayli_aciklama'];
$tur = $_POST['tur'];

$sql = "INSERT INTO oyunlar (resim_url, baslik, aciklama, detayli_aciklama, tur) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $resim_url, $baslik, $aciklama, $detayli_aciklama, $tur);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Oyun eklenemedi."]);
}

$stmt->close();
$conn->close();
?>