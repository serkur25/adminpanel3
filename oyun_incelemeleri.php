<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Oyun İncelemeleri</title>
        <link rel="stylesheet" href="style.css">
        <style>
        body {
            background-color: #444;
            color: white;
            font-family: Arial, sans-serif;
        }

        .oyunlar {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
            align-items: flex-start;
            /* Verilerin sola yaslanması için */
        }

        .oyun {
            display: flex;
            background-color: #444;
            border-radius: 10px;
            padding: 10px;
            position: relative;
            width: 100%;

            /* Divlerin tam genişlikte olmasını sağlamak için */
        }

        .oyun img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            margin-right: 20px;
        }

        .oyun .info {
            flex-grow: 1;
        }

        .oyun .info h2 {
            font-size: 1.2em;
            margin: 0;
            color: yellow;
        }

        .oyun .info p {
            margin: 5px 0;
        }

        .oyun button {
            background-color: red;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin: 20px 0;
        }

        .pagination button {
            background-color: #444;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .pagination button:disabled {
            background-color: #666;
            cursor: not-allowed;
        }

        #page-info {
            font-size: 16px;
        }

        footer {
            text-align: center;
            color: white;
            margin-top: 50px;
            padding: 20px;
            background-color: #222;
        }

        .sosyal-medya {
            margin-top: 10px;
        }

        .sosyal-medya a {
            margin-right: 10px;
        }

        .sosyal-medya img {
            width: 30px;
            height: 30px;
        }
        </style>
    </head>

    <body>
        <?php include 'navbar.html'; ?>

        <div class="oyunlar"></div>

        <div class="pagination">
            <button id="prev-btn">Önceki</button>
            <span id="page-info"></span>
            <button id="next-btn">Sonraki</button>
        </div>

        <footer>
            <div class="sosyal-medya">
                <a href="#"><img src="facebook-icon.png" alt="Facebook"></a>
                <a href="#"><img src="twitter-icon.png" alt="Twitter"></a>
                <a href="#"><img src="instagram-icon.png" alt="Instagram"></a>
            </div>
            <p>&copy; 2024 Oyun İnceleme Sitesi. Tüm Hakları Saklıdır.</p>
        </footer>

        <script src="script.js"></script>
    </body>

</html>