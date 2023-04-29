
// Fonction pour passer a la semaine suivante
function nextweek(){
    // Création d'un objet XMLHttpRequest pour envoyer une requête AJAX
    var xhr = new XMLHttpRequest();
    // Configuration de la requête AJAX
    xhr.open('POST', 'nextweek.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // Envoi de la requête AJAX
    xhr.send();
    // Rechargement de la page
    location.reload();
}

let right_arrow = document.getElementById('right_arrow');
right_arrow.addEventListener('click', nextweek);

// Fonction pour revenir a la semaine precedente
function pastweek(){
    // Création d'un objet XMLHttpRequest pour envoyer une requête AJAX
    var xhr = new XMLHttpRequest();
    // Configuration de la requête AJAX
    xhr.open('POST', 'pastweek.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // Envoi de la requête AJAX
    xhr.send();
    // Rechargement de la page
    location.reload();
}
let left_arrow = document.getElementById('left_arrow');
left_arrow.addEventListener('click', pastweek);

//Fonction qui ouvre le formulaire pour ajouter un cours 
function openform(){
    let form = document.querySelector('.pop_up');
    form.style.display = 'grid';
}
let openBtn = document.getElementById('add');
openBtn.addEventListener('click', openform);

// Fonction pour fermer le formulaire 
function closeform(){
    let form = document.querySelector('.pop_up');
    form.style.display = 'none';
}
let closeBtn = document.getElementById('close');
closeBtn.addEventListener('click',closeform);