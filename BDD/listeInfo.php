<?php
// Charger le fichier JSON
$enseignants_json = file_get_contents('enseignants/enseignants.json');
$cours_json = file_get_contents('cours/cours.json');
$salles_json = file_get_contents('salles/salles.json');

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
    <link rel="stylesheet" href="bdd.css">
    <script>
        function ajouterEnseignant() {
            let id = prompt("Entrez l'ID du nouvel enseignant :");
            let nom = prompt("Entrez le nom du nouvel enseignant :");
            if (id && nom) {
                location.href = "enseignants/ajouter_enseignants.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function ajouterSalle() {
            let id = prompt("Entrez l'ID de la nouvelle salle :");
            let nom = prompt("Entrez le nom de la nouvelle salle :");
            if (id && nom) {
                location.href = "salles/ajouter_salle.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function ajouterCours() {
            let id = prompt("Entrez l'ID du nouveau cours :");
            let nom = prompt("Entrez le nom du nouveau cours :");
            if (id && nom) {
                location.href = "cours/ajouter_cours.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function modifierCours(id) {
            let nouveauNom = prompt("Entrez le nouveau nom du cours :");
            if (nouveauNom) {
                location.href = "cours/modifier_cours.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function modifierSalle(id) {
            let nouveauNom = prompt("Entrez le nouveau nom de la salle :");
            if (nouveauNom) {
                location.href = "salles/modifier_salle.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function modifierEnseignant(id) {
            let nouveauNom = prompt("Entrez le nouveau nom de l'enseignant :");
            if (nouveauNom) {
                location.href = "enseignants/modifier_enseignant.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function supprimerCours(id) {
            if (confirm("Voulez-vous vraiment supprimer ce cours ?")) {
                location.href = "cours/supprimer_cours.php?id=" + id;
            }
        }

        function supprimerSalle(id) {
            if (confirm("Voulez-vous vraiment supprimer cette salle ?")) {
                location.href = "salles/supprimer_salle.php?id=" + id;
            }
        }

        function supprimerEnseignant(id) {
            if (confirm("Voulez-vous vraiment supprimer cet enseignant ?")) {
                location.href = "enseignants/supprimer_enseignants.php?id=" + id;
            }
        }
        
    </script>
</head>


<body>
    <div class="column">
        <!-- Affichage des enseignants -->
        <h1>Enseignants</h1>
        <ul>
            <?php foreach ($enseignants as $id => $nom): ?>
                <li>
                <button onclick="modifierEnseignant('<?php echo $id; ?>')">≈</button>
                <button onclick="supprimerEnseignant('<?php echo $id; ?>')">-</button>
                <?php echo "$id: $nom"; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="ajouterEnseignant()">Ajouter un Enseignant</button>
    </div>

    <div class="column">
        <!-- Affichage des salles -->
        <h1>Salles</h1>
        <ul>
            <?php foreach ($salles as $id => $nom): ?>
                <li>
                <button onclick="modifierSalle('<?php echo $id; ?>')">≈</button>
                <button onclick="supprimerSalle('<?php echo $id; ?>')">-</button>
                <?php echo "$id: $nom"; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="ajouterSalle()">Ajouter une salle</button>
    </div>

    <div class="column">
        <!-- Affichage des cours -->
        <h1>Cours</h1>
        <ul>
            <?php foreach ($cours as $id => $nom): ?>
                <li>
                    <button onclick="modifierCours('<?php echo $id; ?>')">≈</button>
                    <button onclick="supprimerCours('<?php echo $id; ?>')">-</button>
                    <?php echo "$id: $nom"; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="ajouterCours()">Ajouter un cours</button>
    </div>
</body>

</html>
