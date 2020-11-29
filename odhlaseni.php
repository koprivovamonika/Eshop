<?php
    session_start();

    unset($_SESSION["login"]);
    unset($_SESSION["id_uzivatel"]);
    echo "<h2>Uzivatel byl odhlasen</h2>";

header("Location: index.php");

  ?>
