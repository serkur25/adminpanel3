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

$id = $_POST['id'];
$resim_url = $_POST['resim_url'];
$baslik = $_POST['baslik'];
$aciklama = $_POST['aciklama'];
$detayli_aciklama = $_POST['detayli_aciklama'];
$tur = $_POST['tur'];

$sql = "UPDATE oyunlar SET resim_url = ?, baslik = ?, aciklama = ?, detayli_aciklama = ?, tur = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $resim_url, $baslik, $aciklama, $detayli_aciklama, $tur, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Oyun güncellenemedi."]);
}

$stmt->close();
$conn->close();
?>