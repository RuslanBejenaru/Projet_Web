<?php
if (isset($_GET['id'], $_GET['nom'])) {
    $id = $_GET['id'];
    $nom = $_GET['nom'];

    $enseignants_json = file_get_contents('enseignants.json');
    $enseignants = json_decode($enseignants_json, true);

    $enseignants[$id] = $nom;

    file_put_contents('enseignants.json', json_encode($enseignants, JSON_PRETTY_PRINT));
    header("Location: ../listeInfo.php");
} else {
    echo "Erreur lors de la modification.";
}
?>