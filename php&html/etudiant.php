<?php
    session_start();
?>

<!DOCTYPE html>

<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <title>EDT</title>
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'><link rel="stylesheet" href="../css/etudiant.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    </head>

<body>
    <script src="../java/script.js"></script>
    <?php
        if (!isset($_POST['sem'])){
            $_POST['sem']=1;
        }
          
        if (isset($_POST['submit'])) {
            if(isset($_POST['salle']) && isset($_POST['num_semaine']) && isset($_POST['jour']) && isset($_POST['groupe']) && isset($_POST['heure_debut']) && isset($_POST['nom_cours']) && isset($_POST['type_cours']) && isset($_POST['enseignant']) && isset($_POST['heure_fin'])){
                
                // On récupère les données du formulaire
                $sem = $_POST['num_semaine'];
                $semaine = 'Semaine ' . $sem;
                $jour = $_POST['jour'];
                $groupe = $_POST['groupe'];
                $heure_debut = $_POST['heure_debut'];
                $nom_cours = $_POST['nom_cours'];
                $type_cours = $_POST['type_cours'];
                $enseignant = $_POST['enseignant'];
                $heure_fin = $_POST['heure_fin'];
                $salle = $_POST['salle'];

                // Charger le fichier JSON
                $json = file_get_contents('../json/slots.json');

                // Convertir le JSON en tableau PHP
                $data = json_decode($json, true);

                // Ajouter le nouveau cours
                $new_course = [
                    "debut" => $heure_debut,
                    "fin" => $heure_fin,
                    "type" => $type_cours,
                    "matiere" => $nom_cours,
                    "enseignant" => $enseignant,
                    "salle" => $salle
                ];
                $data[$semaine][0][$jour][0][$groupe][] = $new_course;

                // Sauvegarder les modifications dans le fichier JSON
                $json = json_encode($data, JSON_PRETTY_PRINT);
                file_put_contents('../json/slots.json', $json);
            }
        }

        // Fonction pour savoir si un cours commence pour un jour et un groupe et une heure donnée
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

        // Fonction qui incrémente la semaine en cours de 1 pour passer à la prochaine
        function semaineprochaine($semaine_en_cours){
            if($semaine_en_cours+1 <= 52){
                $semaine_en_cours = $semaine_en_cours+1;
            }
        }

        // Fonction qui décrémente la semaine en cours de 1 pour revenir à la précédente
        function semainepecedente($semaine_en_cours){
            if($semaine_en_cours-1 >= 1){
                $semaine_en_cours = $semaine_en_cours-1;
            }
        }

        // Navigation entre les semaines
        echo'<header>';
            echo'<img src="../img/logo.png" height="40px" id="logo">';
            echo'<profil>';
                echo'<a><img src="../img/guest.png" id="profile-pic"></a>';
            echo'</profil>';
        echo'</header>';
        echo'<hr>';
        echo'<div class="navigation_semaine">';
            echo'<container>';
                echo'<img src="../img/left_arrow.png" class="arrow" id="left_arrow" onclick="pastweek();">';
                echo'<div><p id="semaine" data-sem="' . $_SESSION['sem'] . '">Semaine ' . $_SESSION['sem'] .'</p></div>';
                echo '<img src="../img/right_arrow.png" class="arrow" id="right_arrow" onclick="nextweek();">';
            echo'</container>';
        echo'</div>';
        //Debut de notre tableau
        echo '<table id="calendrier">';
            echo '<thead>';
                // La premiere ligne qui constituera notre entete avec 'Horaires' qui prendra l'équivalent de deux lignes
                echo '<tr>';
                    echo '<th rowspan="2" class="jour" >Horaires</th>';
                    echo '<th colspan="2" class="jour" >Lundi</th>';
                    echo '<th colspan="2" class="jour" >Mardi</th>';
                    echo '<th colspan="2" class="jour" >Mercredi</th>';
                    echo '<th colspan="2" class="jour" >Jeudi</th>';
                    echo '<th colspan="2" class="jour" >Vendredi</th>';
                echo '</tr>';
                // La deuxieme ligne qui separera chaque colonne précédente en deux pour nos deux groupes différents
                echo '<tr>';
                    echo'<th>Groupe1</th>';
                    echo'<th>Groupe2</th>';
                    echo'<th>Groupe1</th>';
                    echo'<th>Groupe2</th>';
                    echo'<th>Groupe1</th>';
                    echo'<th>Groupe2</th>';
                    echo'<th>Groupe1</th>';
                    echo'<th>Groupe2</th>';
                    echo'<th>Groupe1</th>';
                    echo'<th>Groupe2</th>';
                echo'</tr>';
            echo'</thead>';

            // On touche au 
            echo'<tbody>';
            
                // Tableau pour stocker les minutes
                $minutes = array('00','15','30','45');
                $taille = count($minutes);

                // Tableau pour stocker les heures
                $heures = array('08','09','10','11','12','13','14','15','16','17','18','19');
                $size = count($heures);

                // Plage Horaires
                $plages_horaires = array();
                for ($i = 0; $i < $size-1; $i++) {
                    for ($j = 0; $j < $taille-1; $j++) {
                        $plage_horaire =  $heures[$i] .':'. $minutes[$j] . '-' . $heures[$i] .':'. $minutes[$j+1] ;
                        array_push($plages_horaires, $plage_horaire);
                    }
                    $plage_horaire = $heures[$i] .':'. $minutes[3] . '-' . $heures[$i+1] . ':'. $minutes[0] ;
                    array_push($plages_horaires, $plage_horaire);   
                }
                
            
                // Emploi du temps 
                $json_file = file_get_contents("../json/slots.json");
                $data = json_decode($json_file, true);

                $nb_plage_horaire = count($plages_horaires);
                $i=0;
                // Pour chaque horaire
                $semaine_en_cours = "Semaine " . $_SESSION['sem'];
                if (array_key_exists($semaine_en_cours, $data)) {
                    $data = $data[$semaine_en_cours];
                    $data = $data[0];
                    while($i<$nb_plage_horaire){
                        $horaires = $plages_horaires[$i];
                        // On ouvre une ligne
                        echo '<tr>';
                        // On place l'horaire en colonne 1
                        echo '<td>'.$horaires. '</td>';
                        
                        // Horaire correspond à l'horaire de début de la plage horaire exemple "08:00-08:15" sera "08:00"
                        $horaire = substr($horaires,0,5);

                        // Les jours de la semaine
                        $days = array("lundi","mardi","mercredi","jeudi","vendredi");
                        // Les groupes
                        $groups = array("groupe1","groupe2");

                        foreach($days as $day){
                            foreach($groups as $group){
                                // Si l'horaire est déjà occupé je ne fais rien pas besoin de creer un case puisqu'elle est déjà remplie
                                if (crenau_occupe($data,$day,$group,$horaire)){ }
                                // Si un cours commence a cette horaire
                                else if(cours_commence($data,$day,$group,$horaire)){
                                    // On crée une case
                                    echo '<td';
                                    // On remplit la case du tableau avec le rowpsan correspondant d'après le l'heure de début et celle de la fin
                                    $heure_de_debut = intval(substr($horaire,0,2));
                                    $minute_de_debut= intval(substr($horaire,3,5));
                                    $heure_de_fin = intval(substr(fin_cours($data,$day,$group,$horaire),0,2));
                                    $minute_de_fin= intval(substr(fin_cours($data,$day,$group,$horaire),3,5));
                                    // formule pour avoir le nombre de plage horaire de 15 minutes pour le cours
                                    $nb_ligne = (($heure_de_fin-$heure_de_debut)*4) + (abs($minute_de_fin-$minute_de_debut)/15);
                                    // info_cours
                                    $info_cours = info_cours($data,$day,$group,$horaire);
                                    // on détermine le nombre de plages horaire de 15 minutes que le cours prend entre autre le nombre de rowspan de lignes qu'il prendra
                                    if($minute_de_fin < $minute_de_debut){
                                        $nb_ligne = (($heure_de_fin-$heure_de_debut)*4) - (abs($minute_de_fin-$minute_de_debut)/15);
                                    }
                                    else {
                                        $nb_ligne = (($heure_de_fin-$heure_de_debut)*4) + (abs($minute_de_fin-$minute_de_debut)/15);
                                    }
                                    // On récupère les données du cours
                                    $info_cours = info_cours($data,$day,$group,$horaire);
                                    // Puis on les affiche dans la case qu'on a créé avec les rowspan correspondant
                                    echo " rowspan=". $nb_ligne . " style='cursor:pointer;'" . " class=". $info_cours[0]. ">" . $info_cours[0] ."<br>" . $info_cours[1] ."<br>". $info_cours[2] ."<br>" . $info_cours[3] . "</td>" ;
                                }
                                // Sinon si la plage horaire n'est ni occupé ni annonce le début d'un cours alors on crée une case vide
                                else { echo "<td>" . "</td>"; }
                            }
                        }
                        // Une fois qu'on a rempli les données de chaque ligne correspondant a notre horaire on clos la ligne
                        echo "</tr>";
                        // Enfin on passe à la suivante
                        $i++;
                    }
                }
                else {
                    while($i<$nb_plage_horaire){
                        $horaires = $plages_horaires[$i];
                        // On ouvre une ligne
                        echo '<tr>';
                        // On place l'horaire en colonne 1
                        echo '<td>'.$horaires. '</td>';

                        // Les jours de la semaine
                        $days = array("lundi","mardi","mercredi","jeudi","vendredi");
                        // Les groupes
                        $groups = array("groupe1","groupe2");
                        
                        // On remplit toutes la cases par du vide
                        foreach($days as $day){
                            foreach($groups as $group){
                                echo "<td></td>";
                            }
                        }

                        // On ferme la ligne
                        echo '</tr>';
                        $i++;
                    }
                }
            
                
            echo'</tbody>';
        echo'</table>';
    ?>
</body>

<img src="../img/plus.png" id="add" onclick="openform();">
<!-- Mon pop up qui contiendra mon formulaire pour ajouter les cours -->
<div class="pop_up">
    <!-- L'icone Croix pour fermer le pop-up -->
    <i class="uil uil-multiply" id="close" onclick="closeform()"></i>
    <!-- Le formulaire -->
    <form action="etudiant.php" method="POST" id="form" >
        <div class=form>
            <!-- Le numéro de semaine du cours a ajouté -->
            <div class="info">
                <label for="num_semaine">Semaine :</label>  
                <input type="number" id="num_semaine" name="num_semaine" min="1" max="52" required><br><br>
            </div>
            <!-- Le jour du cours a ajouté -->
            <div class="info">
                <label for="jour">Jour :</label>
                <select id="jour" name="jour" required>
                    <option value="lundi">Lundi</option>
                    <option value="mardi">Mardi</option>
                    <option value="mercredi">Mercredi</option>
                    <option value="jeudi">Jeudi</option>
                    <option value="vendredi">Vendredi</option>
                </select><br><br>
            </div>
            <!-- Le groupe concerné par le cours a ajouté -->
            <div class="info">
            <label for="groupe">Groupe:</label>
            <select id="groupe" name="groupe" required>
                <option value="groupe1">Groupe 1</option>
                <option value="groupe2">Groupe 2</option>
            </select><br><br>
            </div>
            <!-- La matière du cours a ajouté -->
            <div class='info'>
                <label for="nom_cours">Matière :</label>
                <input type="text" id="nom_cours" name="nom_cours" required><br><br>
            </div>
            <!-- On précise si c'est un cours, tp ou examen -->
            <div class='info'>
                <label for="type_cours">Type de cours :</label>
                <select id="type_cours" name="type_cours" required>
                    <option value="TP">TP</option>
                    <option value="Cours">Cours</option>
                </select><br><br>
            </div>
            <!-- On précise quel enseignant se chargera du cours-->
            <div class='info'>
                <label for="enseignant">Enseignant :</label>
                <input type="text" id="enseignant" name="enseignant" required><br><br>
            </div>
            <!-- On précise la salle ou se tiendra le cours -->
            <div class='info'>
                <label for="salle">Salle :</label>
                <input type="text" id="salle" name="salle" required><br><br>
            </div>
            <!-- On précisera l'heure de début du cours -->
            <div class='info'>
                <label for="heure_debut">Heure de début :</label>
                <input type="time" id="heure_debut" name="heure_debut" step="900" min="08:00:00" max="18:00:00" required><br><br>
            </div>
            <!-- On précisera l'heure de fin du cours -->
            <div class='info'>
                <label for="heure_fin">Heure de fin :</label>
                <input type="time" id="heure_fin" name="heure_fin" step="900"  max="19:00:00" min="08:30:00" required><br><br>
            </div>
        </div>
        <!-- Une fois toutes les cases remplies on soumet le formulaire avec l'input ci dessous -->
        <input type="submit" value="Valider" name="submit">
    </form>
</div>
</html>