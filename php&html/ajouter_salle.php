<?php
if (isset($_GET['id'], $_GET['nom'])) {
    $id = $_GET['id'];
    $nom = $_GET['nom'];

    $salles_json = file_get_contents('../json/salles.json');
    $salles = json_decode($salles_json, true);

    if (!array_key_exists($id, $salles)) {
        $nouvelle_salle = array("id" => $id, "nom" => $nom);
        array_push($salles, $nouvelle_salle);
        file_put_contents('../json/salles.json', json_encode($salles, JSON_PRETTY_PRINT));
        header("Location: listeInfo.php");
    } else {
        echo "Erreur : l'ID de l'enseignant existe déjà.";
    }
} else {
    echo "Erreur lors de l'ajout de l'enseignant.";
}
?>