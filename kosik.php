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

function zvysitPocet($productId, $pocet, $db) {
    $sql = "UPDATE kosik SET pocet = ? WHERE id = '" . $productId . "'";
    if ($stmt = $db->prepare($sql)) {
        $novyPocet = $pocet + 1;
        $stmt->bind_param("i", $novyPocet);
        $stmt->execute();
        header("Location: kosik.php");
    } else {
        echo "<p>Nefunguje</p>";
    }
}

function snizitPocet($productId, $pocet, $db) {
    if ($pocet == 1) {
        odebratProdukt($productId, $db);
    } else {
        $sql = "UPDATE kosik SET pocet = ? WHERE id = '" . $productId . "'";
        if ($stmt = $db->prepare($sql)) {
            $novyPocet = $pocet - 1;
            $stmt->bind_param("i", $novyPocet);
            $stmt->execute();
            header("Location: kosik.php");
        } else {
            echo "<p>Nefunguje</p>";
        }
    }
}

function odebratProdukt($productId, $db) {
    $sql = "DELETE FROM kosik WHERE id = ?";
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        header("Location: kosik.php");
    } else {
        echo "<p>Nefunguje delete.</p>";
    }
}

function potvrditObjednavku($db) {
    $sql = "SELECT kosik.pocet as pocet, produkty.cena as cena, produkty.id as id FROM kosik JOIN produkty "
            . "ON kosik.id_produkt = produkty.id JOIN uzivatele ON kosik.id_uzivatel = uzivatele.id WHERE uzivatele.id = ? ";
    if ($stmt2 = $db->prepare($sql)) {
        $stmt2->bind_param("i", $_SESSION['id_uzivatel']);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $zaznam = $result->fetch_all(MYSQLI_ASSOC);
        if (count($zaznam) > 0) {
            foreach ($zaznam as $row) {
                $sql1 = "INSERT INTO dokoncene_objednavky(id_uzivatel, id_produkt, pocet, cena) VALUES (?,?,?,?)";
                if ($stmt = $db->prepare($sql1)) {
                    $stmt->bind_param("iiii", $_SESSION["id_uzivatel"], $row['id'], $row["pocet"], $row["cena"]);
                    $stmt->execute();
                } else {
                    echo "Nefunguje";
                }
            }
            $sql2 = "DELETE FROM kosik WHERE id_uzivatel = ?";
            if ($stmt1 = $db->prepare($sql2)) {
                $stmt1->bind_param('i', $_SESSION['id_uzivatel']);
                $stmt1->execute();
                header("Location: objednavky.php");
            } else {
                echo "<p>Nefunguje delete.</p>";
            }
        } else {
            echo "<p class='hlaska'>Nejsou tu žádné produkty, nelze tedy dokončit objednávku.</p>";
        }
    }
}

function vypisKosik($db) {
    $sql = "SELECT kosik.id as id, kosik.pocet as pocet, produkty.obrazek as obrazek, produkty.jmeno as jmeno, produkty.cena as cena "
            . "FROM kosik JOIN produkty ON kosik.id_produkt = produkty.id JOIN uzivatele ON kosik.id_uzivatel = uzivatele.id WHERE uzivatele.id = ? ";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i", $_SESSION['id_uzivatel'] );
        $stmt->execute();
        $result = $stmt->get_result();
        $zaznam = $result->fetch_all(MYSQLI_ASSOC);
        if(count($zaznam)>0){
            foreach ($zaznam as $row){
                echo '<div class="cart-item"> <div class="cart-img">' . $row["obrazek"] . '</div>
                    <div>' . $row["jmeno"] . '</div> <div class="cart-control"> <div class="cart-price">cena: <b>' . $row["cena"] . '</b></div>
                    <div class="cart-quantity">počet: <b>' . ($row["pocet"]) . '</b></div>
                    <div class="cart-quantity">celková cena: <b>' . ($row["pocet"] * $row["cena"]) . '</b></div>
                    <a href="kosik.php?pridat=true&&id=' . $row['id'] . '&&pocet=' . $row["pocet"] . '" class="cart-button">+</a>
                    <a href="kosik.php?snizit=true&&id=' . $row['id'] . '&&pocet=' . $row["pocet"] . '" class="cart-button">-</a>
                    <a href="kosik.php?odebrat=true&&id=' . $row['id'] . '" class="cart-button">x</a></div></div>'
                ;
            }
        }else{
             echo "<p class='hlaska'>Nejsou tu žádné produkty.</p>";
        }
    }
}

function celkovaCena($db) {
    $sql = "SELECT SUM(kosik.pocet * produkty.cena) as totalPrice FROM kosik JOIN produkty ON kosik.id_produkt = produkty.id JOIN uzivatele "
            . "ON kosik.id_uzivatel = uzivatele.id WHERE uzivatele.id = ? ";
    if($stmt = $db->prepare($sql)){
        $stmt->bind_param("i",$_SESSION['id_uzivatel']);
        $stmt->execute();
        $result = $stmt->get_result();
        $zaznam = $result->fetch_all(MYSQLI_ASSOC);
        if(count($zaznam)>0){
            foreach ($zaznam as $row){
                echo "<div id='cart-total-price'>Celková cena: " . $row['totalPrice'] . "</div>";
            }
        }else{
            echo "<p class='hlaska'>Nejsou tu žádné produkty.</p>";
        }
    }
}
?>
<h2>KOŠÍK</h2>
<section>
    <?php
    vypisKosik($db);
    celkovaCena($db);
    if (isset($_GET['pridat']) && isset($_GET['id']) && isset($_GET["pocet"])) {
        zvysitPocet($_GET['id'], $_GET["pocet"], $db);
    }
    if (isset($_GET['snizit']) && isset($_GET['id']) && isset($_GET["pocet"])) {
        snizitPocet($_GET['id'], $_GET["pocet"], $db);
    }
    if (isset($_GET['odebrat']) && isset($_GET['id'])) {
        odebratProdukt($_GET['id'], $db);
    }

    if (isset($_POST['button1'])) {
        potvrditObjednavku($db);
    }
    ?>
    <form method="post"> 
        <input type="submit" name="button1" value="POTVRDIT OBJEDNÁVKU"/> 
    </form> 
</section>
</body>
</html>