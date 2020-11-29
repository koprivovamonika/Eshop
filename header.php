<html>
    <head>
        <title>Eshop</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>

        <nav>
            <input type="checkbox" id="drop" />
            <ul class="menu">
                <li><a href="index.php">Produkty</a></li>
                <?php
                if (!isset($_SESSION["login"])) {
                    echo "<li><a href='prihlaseni.php'>Registrace/Přihlášení</a></li>";
                } else {
                    echo "<li><a href='prihlaseni.php'>Odhlášení</a></li>";
                }
                ?>
                <li><a href="kosik.php">Košík</a></li>
                <li><a href="objednavky.php">Moje objednávky</a></li>
            </ul>
        </nav>


        <div id="baner"></div>

