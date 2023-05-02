<?php
    if (isset($_GET['id'], $_GET['nom'])) {

        $id = $_GET['id'];
        $nouveauNom = $_GET['nom'];

        $json = file_get_contents('../json/matieres.json');

        // Convertit le JSON en un tableau associatif PHP
        $donnees = json_decode($json, true);
    
        // Parcourt tous les matieres
        foreach ($donnees as $key => $matiere) {
            // Si l'ID correspond, modifie le nom de l'matiere
            if ($matiere['id'] === $id) {
                $donnees[$key]['nom'] = $nouveauNom;
            }
        }
    
        // Encode le tableau associatif PHP en JSON
        $json = json_encode($donnees, JSON_PRETTY_PRINT);
    
        // Écrit le JSON dans le fichier
        file_put_contents('../json/matieres.json', $json);
        header("Location: listeInfo.php");
    } else {
        echo "Erreur lors de la modification.";
    }
?>