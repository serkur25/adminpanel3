<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Oyun Detayları</title>
        <link rel="stylesheet" href="style.css">
        <style>
        body {
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .haber-detay {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .haber-detay img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        .haber-detay img:hover {
            transform: scale(1.05);
        }

        .haber-detay h2 {
            font-size: 2em;
            margin: 20px 0;
            color: #f39c12;
        }

        .detayli-aciklama {
            margin-top: 20px;
            padding: 20px;
            background-color: #555;
            border-radius: 10px;
            text-align: left;
            white-space: pre-line;
            /* Satır arası boşlukları korur */
        }
        </style>
    </head>

    <body>
        <?php include 'navbar.html'; ?>
        <div class="haber-detay">
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

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);

            $sql = "SELECT gorsel_url, baslik, aciklama FROM haberler WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Veriyi göster
                while($row = $result->fetch_assoc()) {
                    echo '<div class="haber">';
                    echo '<img src="' . $row["gorsel_url"] . '" alt="' . $row["baslik"] . '">';
                    echo '<h2>' . $row["baslik"] . '</h2>';
                    echo '<div class="detayli-aciklama">' . nl2br($row["aciklama"]) . '</div>'; // Detaylı açıklama satır arası boşluklarla birlikte gösterildi
                    echo '</div>';
                }
            } else {
                echo "Bu haber bulunamadı.";
            }
        } else {
            echo "Geçersiz istek. Lütfen doğru bir oyun ID'si sağlayın.";
        }
        $conn->close();
        ?>
        </div>
    </body>

</html>