// On récupère le tableau de candidatures
const candidatures = document.querySelector('.liste_items tbody').rows;

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
    return criteres_statut;
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
 * @brief Fonction permettant de réaliser une suite de recherches dans un tableau HTML
 * @param {*} items Le tableau de lignes
 * @param {*} criteres Le tableau contenant les index et critères des recherches
 * @returns 
 */
function multiFiltre(items, criteres = [], criteres_statut=[], index_statut) {
    if (items === null || index_statut < 0) {
        return;
    }

    // On déclare norte tableau de recherche
    let search = Array.from(items);

    // On filtre selon le statut
    search = search.filter(item => filterParStatut(item, index_statut, criteres_statut));

    // On applique les autres critères
    let i = 0;
    while(search !== null && i < criteres.length) {
        // On implémente l'échantillon
        search = search.filter(item => filtrerPar(item, criteres[i].index, criteres[i].critere));
        i++;
    }

    // On met à jour l'affichage
    retireLignes(items);
    resetLignes(search);
}