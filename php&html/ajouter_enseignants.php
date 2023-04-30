<?php
    if (isset($_GET['id'], $_GET['nom'])) {
        $id = $_GET['id'];
        $nom = $_GET['nom'];

        $enseignants_json = file_get_contents('../json/enseignants.json');
        $enseignants = json_decode($enseignants_json, true);

        if (!array_key_exists($id, $enseignants)) {
            $nouvel_enseignant = array("id" => $id, "nom" => $nom);
            array_push($enseignants, $nouvel_enseignant);
            file_put_contents('../json/enseignants.json', json_encode($enseignants, JSON_PRETTY_PRINT));
            header("Location: listeInfo.php");
        } else {
            echo "Erreur : l'ID de l'enseignant existe déjà.";
        }
    } else {
        echo "Erreur lors de l'ajout de l'enseignant.";
    }
?>
