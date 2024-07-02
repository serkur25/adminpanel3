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
$gorsel_url = $_POST['gorsel_url'];
$baslik = $_POST['baslik'];
$aciklama = $_POST['aciklama'];

$sql = "UPDATE haberler SET gorsel_url = ?, baslik = ?, aciklama = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $gorsel_url, $baslik, $aciklama, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Haber güncellenemedi."]);
}

$stmt->close();
$conn->close();
?>