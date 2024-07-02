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

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_username = $_POST['username'];
$post_password = $_POST['password'];

$sql = "SELECT * FROM kullanicilar WHERE kullanici_adi = ? AND sifre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $post_username, $post_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}

$stmt->close();
$conn->close();
?>