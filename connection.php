<?php

function spojeni() {
    $db = new mysqli("localhost", "root", "", "eshop");
    if ($db->errno > 0)
        die("Je to rozbité :(");
    $db->set_charset("utf8");
    return $db;
}

function registrace() {
    $db = spojeni();
    if (isset($_POST["sended"])) {
        if (empty($_POST["jmeno"]) || empty($_POST["prijmeni"]) || empty($_POST["heslo"]) || empty($_POST["email"])) {
            echo "Vyplň formulář";
        } else {
            $jmeno = $_POST["jmeno"];
            $prijmeni = $_POST["prijmeni"];
            $email = $_POST["email"];
            $heslo = password_hash($_POST["heslo"], PASSWORD_BCRYPT);
            $chyba = 0;


            $sql = "SELECT * FROM uzivatele WHERE email= ?";
            if($stmt1 = $db->prepare($sql)){
                $stmt1->bind_param("s", $email);
                $stmt1->execute();
                $result = $stmt1->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
                if(count($data) > 0){
                    $chyba = 1;
                }   
            }
            

            if ($chyba == 1) {
                echo "Tento email již je v naší databázi.";
            } else {
                $sql5 = "INSERT INTO `uzivatele` (`jmeno`,`prijmeni`, `heslo`, `email`) VALUES (?,?,?,?);";
                if ($stmt = $db->prepare($sql5)) {
                    $stmt->bind_param("ssss", $jmeno, $prijmeni, $heslo, $email);
                    $stmt->execute();
                    $id = $stmt->insert_id;

                    echo "<p class= 'hlaska'>Jste zaregistrováni, můžete se přihlásit</p>";
                }
            }
        }
    }
}

function prihlaseni() {
    $db = spojeni();
    if (!empty($_POST["email1"]) && !empty($_POST["heslo1"])) {
        $email = $_POST["email1"];
        $heslo = $_POST["heslo1"];

        $stmt = $db->prepare("select * from uzivatele where email=? limit 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $zaznam = $result->fetch_assoc();

        if (password_verify($heslo, $zaznam["heslo"])) {
            $_SESSION["login"] = $zaznam["email"];
            $_SESSION["id_uzivatel"] = $zaznam["id"];
            header("Location: index.php");
        } else {
            echo "<p class= 'hlaska'>Zadali jste špatné údaje, zkuste to prosím znovu.</p>";
        }
    }
}