<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Oyun İncelemeleri</title>
        <link rel="stylesheet" href="style.css">
        <style>
        body {
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
        }

        .oyunlar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .oyun {
            width: 200px;
            background-color: #444;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            margin: 10px;
            position: relative;
        }

        .oyun img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            background-color: #222;
            transition: filter 0.3s;
        }

        .oyun h2 {
            font-size: 1.2em;
            margin: 10px 0;
            background: #444;
            padding: 5px;
        }

        .oyun p {
            font-size: 1em;
            margin: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
            box-sizing: border-box;
            transition: opacity 0.3s;
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .oyun:hover img {
            filter: brightness(50%);
        }

        .oyun:hover p {
            opacity: 1;
        }

        .oyun a {
            color: white;
            text-decoration: none;
            display: block;
        }
        </style>
    </head>

    <body>

        <?php include 'navbar.html'; ?>
        <div class="oyunlar">
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

        $sql = "SELECT id, resim_url, baslik, aciklama FROM oyunlar WHERE tur = 'savaş'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Verileri div içinde göster
            while ($row = $result->fetch_assoc()) {
                echo '<div class="oyun">';
                echo '<a href="detay.php?id=' . $row["id"] . '"><img src="' . $row["resim_url"] . '" alt="' . $row["baslik"] . '">';
                echo '<p>' . $row["aciklama"] . '</p></a>';
                echo '<h2>' . $row["baslik"] . '</h2>';
                echo '</div>';
            }
        } else {
            echo "Hiç oyun bulunamadı.";
        }
        $conn->close();
        ?>
        </div>
    </body>

</html>