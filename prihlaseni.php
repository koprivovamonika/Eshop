<?php
session_start();
include "connection.php";
$db = spojeni();
include "header.php";

if (isset($_SESSION["login"])) {
    header("Location: odhlaseni.php");
}
?>

<div class="prihlaseni">
    <form action="" method="POST">
        <h1 class="nadpis_vedlejsi_stranka">Přihlášení</h1>
        <input type="email" name="email1" placeholder="Email" required>
        <input type="password" name="heslo1" placeholder="Heslo" required>
        <input type="submit" name="sended1" value="Odeslat" class="odeslat">
    </form>

    <?php
    prihlaseni();
    ?>
</div>

<div class="registrace">
    <form action="" method="POST">
        <h1 class="nadpis_vedlejsi_stranka">Registrace</h1>
        <input type="text" name="jmeno" placeholder="Jméno" required>
        <input type="text" name="prijmeni" placeholder="Příjmení" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="heslo" placeholder="Heslo" required>
        <input type="submit" name="sended" value="Odeslat" class="odeslat">
    </form>

    <?php
    registrace();
    ?>
</div>
