<?php
    // Charger le fichier JSON
    $enseignants_json = file_get_contents('../json/enseignants.json');
    $matieres_json = file_get_contents('../json/matieres.json');
    $salles_json = file_get_contents('../json/salles.json');

    // Convertir le fichier JSON en tableau PHP associatif
    $enseignants = json_decode($enseignants_json, true);
    $matieres = json_decode($matieres_json, true);
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
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'> <link rel="stylesheet" href="../css/listes.css">
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
                let nom = prompt("Entrez le numéro de la nouvelle salle :");
                if (id && nom) {
                    location.href = "ajouter_salle.php?id=" + id + "&nom=" + encodeURIComponent(nom);
                }
            }

            function ajouterMatiere() {
                let id = prompt("Entrez l'ID de la nouvelle matière :");
                let nom = prompt("Entrez le nom de la nouvelle matière :");
                if (id && nom) {
                    location.href = "ajouter_matiere.php?id=" + id + "&nom=" + encodeURIComponent(nom);
                }
            }

            function modifierMatiere(id) {
                let nouveauNom = prompt("Entrez le nouveau nom du cours :");
                if (nouveauNom) {
                    location.href = "modifier_matiere.php?id=" + id + "&nom=" + encodeURIComponent(nouveauNom);
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

            function supprimerMatiere(id) {
                if (confirm("Voulez-vous vraiment supprimer cette matière ?")) {
                    location.href = "supprimer_matiere.php?id=" + id;
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
        <header>
            <img src="../img/logo.png" height="40px" id="logo">
            <profil>
                <a><img src="../img/guest.png" id="profile-pic"></a>
            </profil>
        </header>;
        <content>
            <div class="column">
                <!-- Affichage des enseignants -->
                <h1>Enseignants</h1>
                <div class='box'>
                    <ul>
                        <?php foreach ($enseignants as $enseignant): ?>
                            <?php
                            $id = $enseignant["id"];
                            $nom= $enseignant["nom"];
                        ?>
                        <li>
                            <button class='edit' onclick="modifierEnseignant('<?php echo $id; ?>')">≈</button>
                            <button class='remove' onclick="supprimerEnseignant('<?php echo $id; ?>')">-</button>
                            <?php echo "$id: $nom"; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button class='add' onclick="ajouterEnseignant()">Ajouter un Enseignant</button>
            </div>

            <div class="column">
                <!-- Affichage des salles -->
                <h1>Salles</h1>
                <div class='box'>
                    <ul>
                        <?php foreach ($salles as $salle): ?>
                            <?php
                                $id = $salle["id"];
                                $nom= $salle["nom"];
                            ?>
                            <li>
                            <button class = 'edit' onclick="modifierSalle('<?php echo $id; ?>')">.</button>
                            <button class = 'remove' onclick="supprimerSalle('<?php echo $id; ?>')">-</button>
                            <?php echo "$id: $nom "?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button class='add' onclick="ajouterSalle()">Ajouter une salle</button>
            </div>

            <div class="column">
                <!-- Affichage des cours -->
                <h1>Matières</h1>
                <div class='box'>
                    <ul>
                        <?php foreach ($matieres as $matiere): 
                            $id = $matiere["id"];
                            $nom= $matiere["nom"];
                        ?>
                        <li>
                            <button class='edit' onclick="modifierMatiere('<?php echo $id; ?>')">≈</button>
                            <button class = 'remove' onclick="supprimerMatiere('<?php echo $id; ?>')">-</button>
                            <?php echo "$id: $nom" ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button class='add' onclick="ajouterMatiere()">Ajouter une matière</button>
            </div>
        </content>
    </body>
</html>