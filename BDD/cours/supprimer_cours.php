<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $cours_json = file_get_contents('../cours/cours.json');
    $cours = json_decode($cours_json, true);

    if (array_key_exists($id, $cours)) {
        unset($cours[$id]);
        file_put_contents('../cours/cours.json', json_encode($cours, JSON_PRETTY_PRINT));
    }
}

header("Location: ../listeInfo.php");
exit;
?>
