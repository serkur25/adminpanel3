<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oyun_incelemeleri";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = isset($_GET['items_per_page']) ? (int)$_GET['items_per_page'] : 15;
$offset = ($page - 1) * $items_per_page;

$sql_total = "SELECT COUNT(*) as total FROM oyunlar";
$result_total = $conn->query($sql_total);
$total_items = $result_total->fetch_assoc()['total'];

$sql = "SELECT id, resim_url, baslik, detayli_aciklama FROM oyunlar ORDER BY id DESC LIMIT $offset, $items_per_page";
$result = $conn->query($sql);

$oyunlar = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $oyunlar[] = $row;
    }
}

$response = [
    'totalItems' => $total_items,
    'items' => $oyunlar
];

echo json_encode($response);

$conn->close();
?>