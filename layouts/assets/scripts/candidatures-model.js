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
 * @param {*} criteres Le tableau de critères
 * @returns 
 */
function recupChamps(liste_champs=[], criteres=[]) {
    // On fait défiler les champs
    for(let i = 0; i < liste_champs.length; i++) {
        // On teste l'intégrité des données
        if(liste_champs[i].value !== "") {
            // On ajoute le critère
            criteres.push({
                'index': i,
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
    return obj[index].innerHTML.trim() == critere;
}

/**
 * @brief Fonction permettant de réaliser une suite de recherches dans un tableau HTML
 * @param {*} items Le tableau de lignes
 * @param {*} criteres Le tableau contenant les index et critères des recherches
 * @returns 
 */
function multiFiltre(items, criteres = []) {
    if (items === null) {
        return;
    }

    let search = Array.from(items);
    for (let i = 0; i < criteres.length; i++) {
        console.log("On lance les recherches sur la sélection : ");
        console.table(search);

        // On vérifie qu'il reste un échantillon de recherche
        if (search === null || search.length === 0) {
            break;
        }

        console.log("Filtre: " + i + " ; " + criteres[i].critere);

        // On implémente l'échantillon
        search = search.filter(item => filtrerPar(item, criteres[i].index, criteres[i].critere));
    }
    retireLignes(items);
    resetLignes(search);
}