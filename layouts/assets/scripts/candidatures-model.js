// On récupère le tableau de candidatures
const candidatures = document.querySelector('.liste_items tbody').rows;
// On récupère l'affichage du nombre de candidatures
let nb_candidatures = document.querySelectorAll('.liste_items .entete h2');
nb_candidatures = nb_candidatures[nb_candidatures.length - 1];

// On récupère les boutons
const rechercher = document.getElementById('rechercher-button');
const filtrer = document.getElementById('filtrer-button');
const trier = document.getElementById('rechercher-button');

// On recupère les formulaires
const rechercher_menu = document.getElementById('rechercher-menu');
const filtrer_menu = document.getElementById('filtrer-menu');
const trier_menu = document.getElementById('trier-menu');

/**
 * @brief Fonction déterminant le code couleur des éléments d'un tableau selon un critère
 * @param {*} items Le tableau
 * @param {*} index L'index de la colonne à partir de la quelle déterminer le code couleur
 * @returns 
 */
function setColor(items=[], index) {
    if(items == null)
        return;

    if(index < 0 || items[0].length < index)
        return; 

    for(let i = 0; i < items.length; i++) {
        switch(items[i].cells[index].textContent) {
            case 'non-traitee':
                items[i].classList.add('non-traitee');
                break;

            case 'en attente':
                items[i].classList.add('en-attente');
                break;

            case 'acceptee':
                items[i].classList.add('acceptee');
                break;

            case 'refusee':
                items[i].classList.add('refusee');
                break;

            default : 
                console.log('Erreur: Type intruvable pour l\'objet :');
                break;
        }
    }
}


/**
 * @brief Fonction permettant de récupérer les données saisies dans un formulaire et de les retourner dans un tableau de critères
 * @param {*} liste_champs Le formulaire
 * @returns Le tableau de critères
 */
function recupChamps(liste_champs=[]) {
    // On vérifie l'intégrité des données
    if(liste_champs.length === 0)
        return; 

    let criteres = [];
    // On fait défiler les champs
    for(let i = 0; i < liste_champs.length; i++) {
        // On teste l'intégrité des données
        if(liste_champs[i].value !== "") {
            // On ajoute le critère
            criteres.push({
                'index': i + 1,
                'critere': liste_champs[i].value.trim()
            });
            
            // On réinitialise le champs
            liste_champs[i].value = null;
        }
    }

    // On retourne la liste de critères
    return criteres;
}
/**
 * @brief Fonction permettant de récupérer les données saisies dans les checkbox du formulaire
 * @param {*} liste_statut La liste des checkbox
 * @returns Le tableau de critères (statut)
 */
function recupChampsStatut(liste_statut=[]) {
    // On vérifie l'intégrité des données
    if(liste_statut.length === 0)
        return; 

    let criteres_statut = [];
    // On récupère les chexboxs
    for(let i = 0; i < liste_statut.length; i++) {
        if(liste_statut[i].checked)
            criteres_statut.push(liste_statut[i].name);
    }

    // On retourne la liste de critères 
    return {
        'index': 0, 
        'criteres': criteres_statut
    };
}
function recupChapsDate(liste_date=[]) {
    // On vérifie l'intégrité des données
    if(liste_date.length === 0 || 2 < liste_date.length)
        return; 

    let criteres_date = [];
    // On récupère les dates
    if(liste_date[0].value) {
        criteres_date.push({
            'type': 'min', 
            'value': new Date(liste_date[0].value)
        });
        liste_date[0].value = null;
    }
        
    if(liste_date[1].value) {
        criteres_date.push({
            'type': 'max', 
            'value': new Date(liste_date[1].value)
        });
        liste_date[1].value = null;
    }

    // On retourne la liste de critères 
    return {
        'index': 7, 
        'criteres': criteres_date
    };
}


/**
 * @brief Fonction permettant d'effectuer une recherche dans un tableau HTML
 * @param {*} item La ligne du tableau
 * @param {*} index La colonne dans laquelle on effectue la recherche
 * @param {*} critere La valeur recherchée
 * @returns 
 */
function filtrerPar(item, index, critere) {
    // On vérifie l'intégrité de l'index
    if (index < 0 || index >= item.cells.length) {
        return false;
    }

    // On récupère les différentes cellules de la ligne
    const obj = item.cells;

    // return obj[index].innerHTML == critere;
    return obj[index].innerHTML.trim() === critere;
}
/**
 * @brief Fonction permettant de filtrer les candidatures selon leur statut
 * @param {*} item La candidature
 * @param {*} index L'indice de la colone contenant le statut
 * @param {*} criteres Le tableau de statuts acceptés dans la recherche
 * @returns 
 */
function filterParStatut(item, index, criteres=[]) {
    // On vérifie l'intégrité dess données
    if(criteres.length === 0 || index < 0)
        return;

    // On fait défiler les criteres
    let i = 0, find = false;
    while(!find && i < criteres.length) {
        if(item.cells[index].innerHTML.trim() === criteres[i])
            find = true;
        i++;
    }

    return find;
}
/**
 * @brief Fonction permettant de filtrer les candidatures selon leur date de disponibilité
 * @param {*} item La candidature
 * @param {*} index L'indice de la colonne contenant la disponibilité
 * @param {*} date_min La date minimale à respecter
 * @param {*} date_max La date maximale à respecter
 * @returns 
 */
function filtrerParDate(item, index, critere_date=[]) {
    // On vérifie l'intégrité des données
    if(index < 0 || critere_date === null)
        return; 

    // On déclare les variables tampons
    const date = new Date(item.cells[index].innerHTML.trim());
    let i = 0, res = true;

    // On teste
    while(res && i < critere_date.length) {
        // On teste le critère
        switch(critere_date[i].type) {
            case 'min': 
                res = res && critere_date[i].value <= date;
                break;

            case 'max':
                res = res && date <= critere_date[i].value;
                break;   

            default: 
                console.log("Critère non reconnu");
                console.log(critere_date[i]);
                break;
        } 
        // On implémente
        i++;
    }
    
    // On retourne le résultat
    return res;
}

/**
 * @brief Fonction permettant de réaliser une suite de recherches dans un tableau HTML
 * @param {*} items Le tableau de lignes
 * @param {*} criteres Le tableau contenant les index et critères des recherches
 * @returns 
 */
function multiFiltre(items, criteres = [], criteres_statut=null, criteres_date=null) {
    if (items === null || criteres_statut.index < 0) {
        return;
    }

    // On déclare norte tableau de recherche
    let search = Array.from(items);

    // On filtre selon le statut
    search = search.filter(item => filterParStatut(item, criteres_statut.index, criteres_statut.criteres));

    // On filtre selon le statut
    search = search.filter(item => filtrerParDate(item, criteres_date.index, criteres_date.criteres));

    // On applique les autres critères
    let i = 0;
    while(search !== null && i < criteres.length) {
        // On implémente l'échantillon
        search = search.filter(item => filtrerPar(item, criteres[i].index, criteres[i].critere));
        i++;
    }

    // On retourne la sélection après filtres
    return search;
}