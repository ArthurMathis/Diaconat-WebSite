// On récupère le tableau de candidatures
let candidatures = recupCandidatures();
const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);
// On récupère l'affichage du nombre de candidatures
let nb_candidatures = document.querySelectorAll('.liste_items .entete h2');
nb_candidatures = nb_candidatures[nb_candidatures.length - 1];

/**
 * @brief Fonction téléchargeant le tableau de candidatures dans le script
 */
function recupCandidatures() {
    return document.querySelector('.liste_items .table-wrapper table tbody').rows;
}

// FONCTION DE COULEURS

/**
 * @brief Fonction déterminant le code couleur des éléments d'un tableau selon un critère
 * @param {*} items Le tableau
 * @param {*} index L'index de la colonne à partir de la quelle déterminer le code couleur
 * @returns 
 */
function setColorStatut(items=[], index) {
    if(items == null)
        return;

    if(index < 0 || items[0].length < index)
        return; 

    for(let i = 0; i < items.length; i++) {
        switch(items[i].cells[index].textContent) {
            case 'non traitee':
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
 * @brief Fonction déterminant le code couleur des éléments d'un tableau se lon un critère
 * @param {*} items Le tableau
 * @param {*} index L'index de la colonne à partir de laquelle déterminer le code couleur
 * @returns 
 */
function setColorSource(items=[], index) {
    if(items == null)
        return;

    if(index < 0 || items[0].length < index)
        return; 

    for(let i = 0; i < items.length; i++) {
        switch(items[i].cells[index].textContent) {
            case 'Email':
                items[i].classList.add('email');
                break;

            case 'Hellowork':
                items[i].classList.add('hellowork');
                break;

            case 'Hublo':
                items[i].classList.add('hublo');
                break;

            case 'Telephone':
                items[i].classList.add('telephone');
                break;

            default : 
                console.log('Erreur: Type intruvable pour l\'objet :');
                break;
        }
    }
}
/**
 * @brief Fonction assignant un code couleur selon les diponibiltés
 * @param {*} items Le tableau de candidatures
 * @param {*} index La colonnes contenant les disponibilités
 */
function setColorDispo(items=[], index) {
    // On génère la date actuelle
    const current_date = new Date();

    // On compare les disponibilités 
    for(let i = 0; i < items.length; i++) {
        const date = new Date(items[i].cells[index].innerHTML.trim());

        // On assigne la couleur
        if(date < current_date)
            items[i].classList.add('date_depassee');
    }
}


// FONCTIONS DE FILTRES
/**
 * @brief Fonction permettant de récupérer les données saisies dans un formulaire et de les retourner dans un tableau de critères
 * @param {*} liste_champs Le formulaire
 * @returns Le tableau de critères
 */
function recupFiltreChamps(liste_champs=[]) {
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
                'index':  i < 1 ? i + 3 : i + 5,
                'critere': liste_champs[i].value.trim()
            });
            
            // On réinitialise le champs
            liste_champs[i].value = null;
        }
    }

    // On retourne la liste de critères
    return criteres;
}
function recupRechercheChamps(liste_champs=[]) {
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
                'index':  i + 1,
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
/**
 * @brief Fonction permettant de récupérer les données saisies dans les sélections de dates du formulaire
 * @param {*} liste_date la liste des dates
 * @returns 
 */
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

    if(criteres_date)
        // On retourne la liste de critères 
        return {
            'index': 7, 
            'criteres': criteres_date
        };

    else return null;
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

    console.log("Item : " + obj[index].textContent.trim());

    return obj[index].textContent.trim() === critere;
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
        if(item.cells[index].textContent.trim() === criteres[i])
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
    const date = new Date(item.cells[index].textContent.trim());
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
    if (items === null || (criteres_statut !== null && criteres_statut.index < 0) 
        || (criteres_date !== null && criteres_date.index < 0)) {
        return;
    }

    // On déclare norte tableau de recherche
    let search = Array.from(items);

    if(criteres_statut)
        // On filtre selon le statut
        search = search.filter(item => filterParStatut(item, criteres_statut.index, criteres_statut.criteres));

    if(criteres_date)    
        // On filtre selon le statut
        search = search.filter(item => filtrerParDate(item, criteres_date.index, criteres_date.criteres));

    // On applique les autres critères
    let i = 0;
    while(search !== null && i < criteres.length) {
        console.log("On filtre selon le critère : " + criteres[i].critere + " dans la colonne : " + criteres[i].index);
        // On implémente l'échantillon
        search = search.filter(item => filtrerPar(item, criteres[i].index, criteres[i].critere));
        i++;
    }

    // On retourne la sélection après filtres
    return search;
}


// FONCTION DE TRIS

/**
 * @brief Fonction permettant de réaliser le tri entre des entiers
 * @param {*} item1 La Ligne 1
 * @param {*} item2 La ligne 2
 * @param {*} index La colonne contenant les entiers à comparer
 * @returns 
 */
function trierSelonInteger(item1=[], item2=[], index) {
    // On convertit le texte en nombres entiers
    const x1 = parseInt(item1.cells[index].textContent.trim()) || 0;
    const x2 = parseInt(item2.cells[index].textContent.trim()) || 0;

    // On compare
    return x1 - x2;
}
/**
 * @brief Fonction permettant de réaliser le tri entre des chaines de caractères
 * @param {*} item1 La Ligne 1
 * @param {*} item2 La ligne 2
 * @param {*} index La colonne contenant les chaines de caractères à comparer
 * @returns 
 */
function trierSelonString(item1=[], item2=[], index) {
    // On passe le texte en minuscle avant comparaison
    const s1 = item1.cells[index].textContent.trim().toLowerCase();
    const s2 = item2.cells[index].textContent.trim().toLowerCase();

    // On compare
    if(s1 < s2)
        return -1;
    if(s2 < s1)
        return 1;
    else 
        return 0;
}
/**
 * @brief Fonction permettant de réaliser le tri entre des dates
 * @param {*} item1 La Ligne 1
 * @param {*} item2 La ligne 2
 * @param {*} index La colonne contenant les dates à comparer
 * @returns 
 */
function trierSelonDate(item1=[], item2=[], index) {
    // On convertit en date
    const d1 = new Date(item1.cells[index].textContent.trim());
    const d2 = new Date(item2.cells[index].textContent.trim());

    // On compare
    return d1 - d2;
}

/**
 * @brief Fonction délclanchant le tri du tableau
 * @param {*} items 
 * @param {*} index 
 * @param {*} croissant 
 * @returns 
 */
function trierSelon(items, index, croissant = true) {
    if (!items) {
        console.log('Tri impossible, items nul');
        return;
    }
    if (index === null) {
        console.log('Tri impossible, index introuvable');
        return;
    }
    if (index < 0) {
        console.log('Tri impossible, index négatif');
        return;
    }
    if (items.length === 0) {
        console.log('Tri impossible, items vide');
        return;
    }
    if (items[0].cells.length <= index) {
        console.log('Tri impossible, index supérieur à dimension items');
        return;
    }


    // On vérifie le sens de tri
    if (typeof croissant !== 'boolean') {
        croissant = true;
    }

    // On déclare le tableau de résultat
    let search = Array.from(items);

    // On sélectionne la méthode de tri
    const item = items[0].cells[index].textContent.trim();
    if (!isNaN(Date.parse(item))) {
        // Si c'est une date
        console.log('On trit selon les dates');
        search.sort((item1, item2) => trierSelonDate(item1, item2, index));

    } else if (!isNaN(parseInt(item))) {
        // Si c'est un nombre
        search.sort((item1, item2) => trierSelonInteger(item1, item2, index));

    } else {
        // Sinon, on considère que c'est une chaîne de caractères
        search.sort((item1, item2) => trierSelonString(item1, item2, index));
    }

    // Si le tri est décroissant
    if (!croissant) {
        search.reverse();
    }

    return search;
}
