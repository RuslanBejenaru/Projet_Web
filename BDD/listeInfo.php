<?php
// Charger le fichier JSON
$enseignants_json = file_get_contents('enseignants.json');
$cours_json = file_get_contents('cours.json');
$salles_json = file_get_contents('salles.json');

// Convertir le fichier JSON en tableau PHP associatif
$enseignants = json_decode($enseignants_json, true);
$cours = json_decode($cours_json, true);
$salles = json_decode($salles_json, true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage et modification des fichiers JSON</title>
    <script>
        function modifierEnseignant(id) {
            let nouveauNom = prompt("Entrez le nouveau nom de l'enseignant :");
            if (nouveauNom) {
                location.href = "modifier_enseignant.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function ajouterEnseignant() {
            let id = prompt("Entrez l'ID du nouvel enseignant :");
            let nom = prompt("Entrez le nom du nouvel enseignant :");
            if (id && nom) {
                location.href = "ajouter_enseignant.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function modifierSalle(id) {
            let nouveauNom = prompt("Entrez le nouveau nom de la salle :");
            if (nouveauNom) {
                location.href = "modifier_salle.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function ajouterSalle() {
            let id = prompt("Entrez l'ID de la nouvelle salle :");
            let nom = prompt("Entrez le nom de la nouvelle salle :");
            if (id && nom) {
                location.href = "ajouter_salle.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function modifierCours(id) {
            let nouveauNom = prompt("Entrez le nouveau nom du cours :");
            if (nouveauNom) {
                location.href = "modifier_cours.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function ajouterCours() {
            let id = prompt("Entrez l'ID du nouveau cours :");
            let nom = prompt("Entrez le nom du nouveau cours :");
            if (id && nom) {
                location.href = "ajoute_cours.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

    </script>
</head>
<body>
    <!-- Affichage des enseignants, des salles et des cours -->
    <h1>Enseignants</h1>
    <ul>
        <?php foreach ($enseignants as $id => $nom): ?>
            <li>
            <button onclick="modifierEnseignant('<?php echo $id; ?>')">Modifier</button>
            <?php echo "$id: $nom"; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <button onclick="ajouterEnseignant()">Ajouter un Enseignant</button>

    <h1>Salles</h1>
    <ul>
        <?php foreach ($salles as $id => $nom): ?>
            <li>
            <button onclick="modifierSalle('<?php echo $id; ?>')">Modifier</button>
            <?php echo "$id: $nom"; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <button onclick="ajouterSalle()">Ajouter une salle</button>

    <h1>Cours</h1>
    <ul>
        <?php foreach ($cours as $id => $nom): ?>
            <li>
                <button onclick="modifierCours('<?php echo $id; ?>')">Modifier</button>
                <?php echo "$id: $nom"; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <button onclick="ajouterCours()">Ajouter un cours</button>
</body>
</html>
