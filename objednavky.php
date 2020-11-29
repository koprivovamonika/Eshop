<?php
session_start();
include "connection.php";
$db = spojeni();
include "header.php";
if (!isset($_SESSION["login"])) {
    header("Location: prihlaseni.php");
}
?>

<?php

function vypisObjednavky($db) {
    $sql = "SELECT dokoncene_objednavky.id as id, dokoncene_objednavky.pocet as pocet, dokoncene_objednavky.cena as cena, produkty.obrazek as obrazek, "
            . "produkty.jmeno as jmeno FROM dokoncene_objednavky JOIN produkty ON dokoncene_objednavky.id_produkt = produkty.id JOIN uzivatele "
            . "ON dokoncene_objednavky.id_uzivatel = uzivatele.id WHERE uzivatele.id =? ";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param("i", $_SESSION['id_uzivatel']);
        $stmt->execute();
        $result = $stmt->get_result();
        $zaznam = $result->fetch_all(MYSQLI_ASSOC);
        if (count($zaznam) > 0) {
            foreach ($zaznam as $row) {
                echo '<div class="cart-item"> <div class="cart-img">' . $row["obrazek"] . '</div>
                    <div>' . $row["jmeno"] . '</div> <div class="cart-control"> <div class="cart-price"> cena: <b>' . $row["cena"] . '</b></div>
                    <div class="cart-quantity">počet:  <b>' . ($row["pocet"]) . '</b></div>
                    <div class="cart-quantity">celková cena:  <b>' . ($row["pocet"] * $row["cena"]) . '</b></div></div></div>';
            }
        } else {
            echo "<p class='hlaska'>Nejsou tu žádné produkty.</p>";
        }
    }
}
?>

<h2>DOKONČENÉ OBJEDNÁVKY</h2>
<section>
    <?php
    vypisObjednavky($db);
    ?>

</section>
</body>
</html>