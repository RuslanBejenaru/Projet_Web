<?php
if (isset($_GET['id'], $_GET['nom'])) {
    $id = $_GET['id'];
    $nom = $_GET['nom'];

    $cours_json = file_get_contents('cours.json');
    $cours = json_decode($cours_json, true);

    $cours[$id] = $nom;

    file_put_contents('cours.json', json_encode($cours, JSON_PRETTY_PRINT));
    header("Location: listeInfo.php");
} else {
    echo "Erreur lors de la modification.";
}
?>