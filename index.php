<?php
session_start();
include "connection.php";
$db = spojeni();
include "header.php";

function pridatDoKosiku($db) {
    if (!empty($_GET["id"])) {
        if (!isset($_SESSION["login"])) {
            header("Location: prihlaseni.php");
        } else {

            $sql1 = "SELECT kosik.pocet, kosik.id FROM `kosik` JOIN uzivatele ON kosik.id_uzivatel = uzivatele.id JOIN produkty ON kosik.id_produkt = produkty.id "
                    . "WHERE uzivatele.id = ? AND produkty.id = ?";
            if($stmt1 = $db->prepare($sql1)){
                $stmt1->bind_param("ii", $_SESSION["id_uzivatel"],$_GET["id"]);
                $stmt1->execute();
                $result = $stmt1->get_result();
                $zaznam = $result->fetch_all(MYSQLI_ASSOC);
                if(count($zaznam) > 0){
                    foreach ($zaznam as $row){
                        $sql = "UPDATE kosik SET pocet = ? WHERE id = '" . $row["id"] . "'";
                        if ($stmt = $db->prepare($sql)) {
                            $novyPocet = $row["pocet"] + 1;
                            $stmt->bind_param("i", $novyPocet);
                            $stmt->execute();
                            header("Location: index.php");
                        } else {
                            echo "<p>Nefunguje update kosik.</p>";
                        }
                    }
                }else{
                    $sql = "INSERT INTO kosik(id_uzivatel, id_produkt, pocet) VALUES(?,?,?)";
                    if ($stmt = $db->prepare($sql)) {
                        $pocet = 1;
                        $stmt->bind_param("iii", $_SESSION["id_uzivatel"], $_GET["id"], $pocet);
                        $stmt->execute();
                        header("Location: index.php");
                    } else {
                        echo "Nefunguje insert kosik.";
                    }
                }
            }
        }
    }
}

function vypisProdukty($db) {
    $sql = "SELECT * FROM `produkty`";
    if($stmt = $db->prepare($sql)){
        $stmt->execute();
        $result = $stmt->get_result();
        $zaznam = $result->fetch_all(MYSQLI_ASSOC);
        if(count($zaznam)>0){
            foreach ($zaznam as $row) {
                echo '<div class="catalog-item">
                        <div class="catalog-img">
                        ' . $row["obrazek"] . '
                      </div>
                    <h3>' . $row["jmeno"] . '</h3>
                    <div>' . $row["cena"] . '</div>
                    <a href="index.php?id=' . $row["id"] . '" 
                        class="catalog-buy-button">Buy</a>
                    </div>';
            }
        }else{
            echo "<p class='hlaska'>Nejsou tu žádné produkty.</p>";
        } 
    }
}
?>
<h2>PRODUKTY</h2>
<section id="catalog-items">
    <?php
    pridatDoKosiku($db);
    vypisProdukty($db);
    ?>
</section>
</body>
</html>