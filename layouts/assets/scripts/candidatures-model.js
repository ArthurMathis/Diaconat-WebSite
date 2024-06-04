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
                'critere': liste_champs[i].value
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
 * @param {*} items Le tableau
 * @param {*} index La colonne dans laquelle on effectue la recherche
 * @param {*} critere La valeur recherchée
 * @returns 
 */
function filtrerPar(items, index, critere) {
    console.log('On lance la recherche de ' + critere + ', dans la colonne: ' + index + ' du tableau:');

    // On déclare le items d'élément à retirer
    let res_recherche = {
        "retireItems": [],
        "valideItems": []
    };

    // On vérifie l'intégrité de l'index
    if(index < 0)
        return;

    console.log("On démarre la lecture");
    // On fait défiler la table
    for(let i = 0; i < items.length; i++) {
        // On récupère les différentes cellules de la ligne
        const obj = items[i].cells;

        // On teste les données
        if(index < obj.length && obj[index].innerHTML != critere) 
            res_recherche.retireItems.push(items[i]);

        else res_recherche.valideItems.push(items[i]);
    }

    console.log('Resultat de la recherche:');
    console.log('Selection valide:');
    console.table(res_recherche.valideItems);
    console.log('Selection à retirer:');
    console.table(res_recherche.retireItems);

    // On retourne les éléments à retirer de la vue
    return res_recherche;
}
/**
 * @brief Fonction permettant de réaliser une suite de recherches dans un tableau HTML
 * @param {*} items Le tableau
 * @param {*} criteres Le tableau contenant les index et critères des recherches
 * @returns 
 */
function multiFiltre(items, criteres=[]) {
    if(criteres == null)
        return;

    let rechercheDans = items;
    for(let i = 0; i < criteres.length; i++) { 
        if(rechercheDans.length == 0)
            break;
        
        // On applique la recherche
        const res_recherche = filtrerPar(rechercheDans, criteres[i].index, criteres[i].critere); 
        rechercheDans = res_recherche.valideItems;
        retireLignes(res_recherche.retireItems);
    }
}
    