<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $enseignants_json = file_get_contents('../enseignants/enseignants.json');
    $enseignants = json_decode($enseignants_json, true);

    if (array_key_exists($id, $enseignants)) {
        unset($enseignants[$id]);
        file_put_contents('../enseignants/enseignants.json', json_encode($enseignants, JSON_PRETTY_PRINT));
    }
}

header("Location: ../listeInfo.php");
exit;
?>