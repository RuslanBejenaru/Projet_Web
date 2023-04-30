<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $salles_json = file_get_contents('../json/salles.json');
    $salles = json_decode($salles_json, true);

    if (array_key_exists($id, $salles)) {
        unset($salles[$id]);
        file_put_contents('../json/salles.json', json_encode($salles, JSON_PRETTY_PRINT));
    }
}

header("Location: listeInfo.php");
exit;
?>
