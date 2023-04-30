<?php
    if (isset($_GET['id'], $_GET['nom'])) {
        $id = $_GET['id'];
        $nom = $_GET['nom'];

        $matieres_json = file_get_contents('../json/matieres.json');
        $matieres = json_decode($matieres_json, true);

        if (!array_key_exists($id, $matieres)) {
            $nouvel_matiere = array("id" => $id, "nom" => $nom);
            array_push($matieres, $nouvel_matiere);
            file_put_contents('../json/matieres.json', json_encode($matieres, JSON_PRETTY_PRINT));
            header("Location: listeInfo.php");
        } else {
            echo "Erreur : l'ID de l'matiere existe déjà.";
        }
    } else {
        echo "Erreur lors de l'ajout de l'matiere.";
    }
?>