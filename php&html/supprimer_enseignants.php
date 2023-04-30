<?php
    if (isset($_GET['id'])) {
        
        $id = $_GET['id'];
        $json = file_get_contents('../json/enseignants.json');

        // Convertit le JSON en un tableau associatif PHP
        $enseignants = json_decode($json, true);

        // Vérifie si l'ID existe dans la liste des professeurs
        if (array_key_exists($id, array_column($enseignants, "id"))) {

            // Convertit le JSON en un tableau associatif PHP

            // Parcourt tous les enseignants
            foreach ($enseignants as $key => $enseignant) {
                // Si l'ID correspond, supprime l'élément correspondant du tableau
                if ($enseignant['id'] === $id) {
                    unset($enseignants[$key]);
                    header("Location: listeInfo.php");
                }
            }

            // Encode le tableau associatif PHP en JSON
            $json = json_encode(array_values($enseignants), JSON_PRETTY_PRINT);

            // Écrit le JSON dans le fichier
            file_put_contents('../json/enseignants.json', $json);

            // Retourne true pour indiquer que l'enseignant a été supprimé avec succès
            return true;
            
        } else {
            // Retourne false si aucun enseignant n'a été trouvé avec l'ID donné
            return false;
        }
    }

    header("Location: listeInfo.php");
    //exit;
?>