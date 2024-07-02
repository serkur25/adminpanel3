<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oyun_incelemeleri";

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$sql = "SELECT id, resim_url, baslik, aciklama FROM oyunlar";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Verileri div içinde göster
    while($row = $result->fetch_assoc()) {
        echo '<div class="oyun">';
        echo '<img src="' . $row["resim_url"] . '" alt="' . $row["baslik"] . '">';
        echo '<h2>' . $row["baslik"] . '</h2>';
        echo '<p>' . $row["aciklama"] . '</p>';
        echo '<a href="detay.php?id=' . $row["id"] . '">Detaylı İnceleme</a>';
        echo '</div>';
    }
} else {
    echo "Hiç oyun bulunamadı.";
}
$conn->close();
?>