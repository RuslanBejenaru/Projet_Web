<?php
    // Charger le fichier JSON
    $enseignants_json = file_get_contents('../json/enseignants.json');
    $cours_json = file_get_contents('../json/slots.json');
    $salles_json = file_get_contents('../json/salles.json');

    // Convertir le fichier JSON en tableau PHP associatif
    $enseignants = json_decode($enseignants_json, true);
    $cours = json_decode($cours_json, true);
    $salles = json_decode($salles_json, true);

    // Fonctions 

    function cours_commence($data, $jour, $groupe, $time){
        $programme = $data[$jour];
        $cours = $programme[0][$groupe];
        $time = strtotime($time);
        foreach($cours as $seance){
            $start = strtotime($seance['debut']);
            if ($start == $time){
                return true;
            }
        }
        return false;
    }

    // Fonction avoir l'heure de fin d'un cours pour un jour et un groupe et une heure donnée si le cours existe bien sur
    function fin_cours($data, $jour, $groupe, $time){
        $programme = $data[$jour];
        $cours = $programme[0][$groupe];
        $time = strtotime($time);
        foreach($cours as $seance){
            $start = strtotime($seance['debut']);
            if ($start == $time){
                return $seance["fin"];
            }
        }
    }

    // Fonction pour savoir si le crenau est occupe pour un jour donné et un groupe donné 
    function crenau_occupe($data, $jour, $groupe, $time){
        $programme = $data[$jour];
        $cours = $programme[0][$groupe];
        $time = strtotime($time);
        foreach($cours as $seance){
            $start = strtotime($seance["debut"]);
            $end = strtotime($seance["fin"]);
            if($start<$time && $time<$end){
                return true;
            }
        }
        return false;
    }

    // Fonction qui renvoie les infos d'un cours pour un heure de debut un groupe un jour donnée
    function info_cours($data, $jour, $groupe, $time){
        $info = array();
        $programme = $data[$jour];
        $cours = $programme[0][$groupe];
        $time = strtotime($time);
        foreach($cours as $seance){
            $start = strtotime($seance['debut']);
            if ($start == $time){
                $type = $seance['type'];
                $matiere = $seance['matiere'];
                $enseignant = $seance['enseignant'];
                $salle = $seance['salle'];
                array_push($info, $matiere);
                array_push($info, $type);
                array_push($info, $enseignant);
                array_push($info, $salle);
            }
        }
        return $info;
    }
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
                location.href = "ajouter_enseignants.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function ajouterSalle() {
            let id = prompt("Entrez l'ID de la nouvelle salle :");
            let nom = prompt("Entrez le nom de la nouvelle salle :");
            if (id && nom) {
                location.href = "ajouter_salle.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function ajouterCours() {
            let id = prompt("Entrez l'ID du nouveau cours :");
            let nom = prompt("Entrez le nom du nouveau cours :");
            if (id && nom) {
                location.href = "ajouter_cours.php?id=" + id + "&nom=" + encodeURIComponent(nom);
            }
        }

        function modifierCours(id) {
            let nouveauNom = prompt("Entrez le nouveau nom du cours :");
            if (nouveauNom) {
                location.href = "modifier_cours.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function modifierSalle(id) {
            let nouveauNom = prompt("Entrez le nouveau nom de la salle :");
            if (nouveauNom) {
                location.href = "modifier_salle.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function modifierEnseignant(id) {
            let nouveauNom = prompt("Entrez le nouveau nom de l'enseignant :");
            if (nouveauNom) {
                location.href = "modifier_enseignant.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
            }
        }

        function supprimerCours(id) {
            if (confirm("Voulez-vous vraiment supprimer ce cours ?")) {
                location.href = "supprimer_cours.php?id=" + id;
            }
        }

        function supprimerSalle(id) {
            if (confirm("Voulez-vous vraiment supprimer cette salle ?")) {
                location.href = "supprimer_salle.php?id=" + id;
            }
        }

        function supprimerEnseignant(id) {
            if (confirm("Voulez-vous vraiment supprimer cet enseignant ?")) {
                location.href = "supprimer_enseignants.php?id=" + id;
            }
        }
        
    </script>
</head>


<body>
    <div class="column">
        <!-- Affichage des enseignants -->
        <h1>Enseignants</h1>
        <ul>
            <?php foreach ($enseignants as $enseignant): ?>
                <?php
                $id = $enseignant["id"];
                $nom= $enseignant["nom"];
                ?>
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
            <?php foreach ($salles as $salle): ?>
                <?php
                    $id = $salle["id"];
                    $nom= $salle["nom"];
                ?>
                <li>
                <button onclick="modifierSalle('<?php echo $id; ?>')">≈</button>
                <button onclick="supprimerSalle('<?php echo $id; ?>')">-</button>
                <?php echo "$id: $nom; "?>
            </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="ajouterSalle()">Ajouter une salle</button>
    </div>

    <div class="column">
        <!-- Affichage des cours -->
        <h1>Cours</h1>
        <ul>
            <?php
                // Charger le fichier JSON
                $json = file_get_contents('../json/slots.json');
                // Convertir le JSON en tableau associatif
                $data = json_decode($json, true);
            ?>
            <li>
                <button onclick="modifierCours('<?php echo $id; ?>')">≈</button>
                <button onclick="supprimerCours('<?php echo $id; ?>')">-</button>
                <!--<?php echo "$id: $nom"; ?>-->
            </li>
        </ul>
        <button onclick="ajouterCours()">Ajouter un cours</button>
    </div>
</body>

</html>
