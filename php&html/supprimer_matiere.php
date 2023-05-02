<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $matieres_json = file_get_contents('../json/matieres.json');
        $matieres = json_decode($matieres_json, true);

        if (array_key_exists($id, $matieres)) {
            unset($matieres[$id]);
            file_put_contents('../json/matieres.json', json_encode($matieres, JSON_PRETTY_PRINT));
        }
    }

    header("Location: listeInfo.php");
    exit;
?>