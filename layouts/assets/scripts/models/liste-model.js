/**
 * @brief Fonction téléchargeant le tableau de candidatures dans le script
 * @param {*} source 
 * @returns 
 */
function recupCandidatures(source) {
    return document.querySelector(source).rows;
}

/**
 * @brief Fonction déterminant le code couleur des éléments d'un tableau selon un e liste de critères
 * @param {*} items Le tableau
 * @param {*} criteres La liste de critères 
 * @param {*} index L'index de la colonne à partir de la quelle déterminer le code couleur
 */
function setColor(items=[], criteres=[], index) {
    // On vérifie l'intégrité d'items
    if (items == null) {
        throw new Error("Erreur lors de la détermination du code couleur. Le tableau ne peut pas être nul !");
    }
    if (!Array.isArray(criteres)) {
        throw new Error("Erreur lors de la détermination du code couleur. La liste de critères doit être de type Array !");
    }
    if (index == null || !Number.isInteger(index) || index < 0) {
        throw new Error("Erreur lors de la détermination du code couleur. L'index doit être un nombre entier non négatif !");
    }
    if (items.length > 0 && items[0].cells.length <= index) {
        throw new Error("Erreur lors de la détermination du code couleur. L'index ne peut pas dépasser la dimension du tableau !");
    }

    // Conversion de items en tableau
    items = Array.from(items);

    // On fait défiler le tableau
    items.forEach(ligne => {
        // On recherche le critere
        let i = 0, find = false;
        while (i < criteres.length && !find) {
            // On compare
            if (ligne.cells[index].textContent.trim() === criteres[i].content.trim()) {
                // On implémente 
                find = true;
                ligne.classList.add(criteres[i].class);
            }
            // On implémente
            i++;
        }

        // On vérifie qu'un critère a été sélectionné
        if (!find) {
            throw new Error("Erreur lors de la détermination du code couleur. La ligne : " + ligne + " ne correspond à aucun critères !");
        }
    });
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


// FONCTIONS DE FILTRE //

// function recupChamps(liste_champs=[]) {
//     // On vérifie l'intgrité des données
//     if (!Array.isArray(liste_champs)) 
//         throw new Error("Erreur lors de la récupération des critères. La liste de critères doit être de type Array !");
//     
//     let criteres = [];
//     // On fait défiler les champs
//     for(let i = 0; i < liste_champs.length; i++) {
//         // On teste l'intégrité des données
//         if(liste_champs[i].champs.value !== "") {
//             // On ajoute le critère
//             criteres.push({
//                 'index': liste_champs[i].index,
//                 'critere': liste_champs[i].champs.value
//             });
//             
//             // On réinitialise le champs
//             liste_champs[i].champs.value = null;
//         }
//     }
// 
//     // On retourne la liste de critères
//     return criteres;
// }
// function recupCheckbox(liste_champs=[]) {
//     // On vérifie l'intgrité des données
//     if (!Array.isArray(liste_champs.champs)) 
//         throw new Error("Erreur lors de la récupération des critères. La liste de critères doit être de type Array !");
// 
//     let criteres_statut = [];
//     liste_champs.champs.forEach(c => {
//         if(c.checked)
//             criteres_statut.push(c.name);
//     });
// 
//     // On retourne la liste de critères 
//     return {
//         'index': liste_champs.index, 
//         'criteres': criteres_statut,
//         'type': 'multi'
//     };
// }
// /**
//  * @brief Fonction permettant de récupérer les données saisies dans les sélections de dates du formulaire
//  * @param {*} liste_date la liste des dates
//  * @returns 
//  */
// function recupChampsDate(liste_date=[]) {
//     // On vérifie l'intégrité des données
//     if(liste_date.champs.length === 0 || 2 < liste_date.champs.length)
//         return; 
// 
//     // On récupère les dates
//     let criteres_date = [];
//     if(liste_date.champs[0].value) {
//         criteres_date.push({
//             type: 'min', 
//             value: new Date(liste_date.champs[0].value)
//         });
//         liste_date.champs[0].value = null;
//     }
//     if(liste_date.champs[1].value) {
//         criteres_date.push({
//             type: 'max', 
//             value: new Date(liste_date.champs[1].value)
//         });
//         liste_date.champs[1].value = null;
//     }
// 
//     if(criteres_date.length > 0)
//         // On retourne la liste de critères 
//         return {
//             index: liste_date.index, 
//             criteres: criteres_date
//         };
// 
//     else return null;
// }

/**
 * @brief Fonction permettant de définir une liste de critères selon une liste de champs textuels 
 * @param {*} champs La liste de champs de saisie
 * @param {*} criteres Le tableau de critères à implémenter
 */
function recupChamps(champs=[], criteres=[]) {
    // On vérifie l'intégrité des données 
    if(!Array.isArray(champs))
        throw new Error("Erreur lors de la récupération des critères. La liste de critères doit être de type Array !");

    // On fait défiler les inputs
    for(let i = 0; i < champs.length; i++) {
        // On teste l'intégrité des données
        if(champs[i].champs.value !== '') {
            // On ajoute le critère
            criteres.push({
                'index': champs[i].index,
                'critere': champs[i].champs.value,
                'type': 'default'
            });

            // On réiitialise le champs
            champs[i].champs
        }
    }
}
/**
 * @brief Fonction permettant de définir une liste de critères selon une liste de checkbox
 * @param {*} champs La liste de champs de saisie
 * @param {*} criteres Le tableau de critères à implémenter
 */
function recupCheckbox(champs=[], criteres=[]) {
    // On vérifie l'intgrité des données
    if (!Array.isArray(champs.champs)) 
        throw new Error("Erreur lors de la récupération des critères. La liste de critères doit être de type Array !");

    // On déclare un tableau tampon
    let new_c = [];
    champs.champs.forEach(c => {
        if(c.checked)
            new_c.push(c.name);
    });

    // On retourne la liste de critères 
    if(new_c.length !== champs.champs.length)
        criteres.push({
            'index': champs.index, 
            'criteres': new_c,
            'type': 'multi'
        });
}
/**
 * @brief Fonction permettant de récupérer les données saisies dans les sélections de dates du formulaire
 * @param {*} liste_date la liste des dates
 * @returns 
 */
function recupChampsDate(champs=[], criteres=[]) {
    // On vérifie l'intégrité des données
    if(champs.champs.length === 0 || 2 < champs.champs.length) {
        console.warn('Le nombre de champs est invalide');
        return; 
    }
        

    // On récupère les dates
    let new_c = [];
    if(champs.champs[0].value) {
        new_c.push({
            'type': 'min', 
            'value': new Date(champs.champs[0].value)
        });
        champs.champs[0].value = null;
    }
    if(champs.champs[1].value) {
        new_c.push({
            'type': 'max', 
            'value': new Date(champs.champs[1].value)
        });
        champs.champs[1].value = null;
    }

    if(new_c.length > 0)
        // On retourne la liste de critères 
        criteres.push({
            'index': champs.index, 
            'criteres': new_c,
            'type': 'date'
        });

    else 
        console.warn("Aucun critère ajouté");
}

/**
 * @brief Fonction permettant de filtrer un tableau selon un filtre à un critère
 * @param {*} item La ligne du tableau
 * @param {*} index La colonne dans laquelle on effectue le filtre
 * @param {*} critere La valeur recherchée
 * @returns 
 */
function filtrerPar(item, index, critere) {
    // On vérifie l'intégrité de l'index
    if (index < 0 || index >= item.cells.length) 
        throw new Error("Impossible d'appliquer le filtre. Indice de invalide !");

    console.log('On compare : ' + item.cells[index].textContent.trim() + ' avec ' + critere);

    // On retourne le résultat du filtre
    return item.cells[index].textContent.trim() === critere;
}
/**
 * @brief Fonction permettant de filtrer un tableau selon un filtre à plusieurs critères
 * @param {*} item La ligne du tableau
 * @param {*} index La colonne dans laquelle on effectue le filtre
 * @param {*} criteres La liste des valeurs recherchées
 */
function filterParCriteres(item, index, criteres=[]) {
    if (index < 0 || item.cells.length <= index) 
        console.warn("Impossible d'appliquer le filtre. Indice de invalide !");

    // On fait défiler les criteres
    let i = 0, find = false;
    while(find === false && i < criteres.length) {
        console.log('On compare : ' + item.cells[index].textContent.trim() + ' avec : ' + criteres[i]);
        // On compare
        if(item.cells[index].textContent.trim() === criteres[i])
            // On implémente 
            find = true;

        // On implémente
        i++;
    }

    // On retourne le réultat du filtre
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
 */
// function multiFiltre(items, criteres = [], criteres_statut=null, criteres_date=null) {
//     if (items === null || (criteres_statut !== null && criteres_statut.index < 0) || (criteres_date !== null && criteres_date.index < 0)) 
//         throw new Error("Erreur lors de la recherche par filtre. Les listes de critères sont incohérentes.");
// 
//     // On déclare notre tableau de recherche
//     let search = Array.from(items);
// 
//     if(criteres_statut)
//         // On filtre selon le statut
//         search = search.filter(item => filterParCriteres(item, criteres_statut.index, criteres_statut.criteres));
// 
//     if(criteres_date)    
//         // On filtre selon le statut
//         search = search.filter(item => filtrerParDate(item, criteres_date.index, criteres_date.criteres));
// 
//     // On applique les autres critères
//     let i = 0;
//     while(search !== null && i < criteres.length) {
//         console.log("On filtre selon le critère : " + criteres[i].critere + ", dans la colonne : " + criteres[i].index);
//         // On implémente l'échantillon
//         search = search.filter(item => filtrerParDate(item, criteres_date.index, criteres_date.criteres));
//         i++;
//     }
// 
//     // On retourne la sélection après filtres
//     return search;
// }

/**
 * @brief Fonction permettant de filtrer un tableau d'élément selon une liste de critères
 * @param {*} items Le tableau
 * @param {*} criteres La liste
 * @returns 
 */
function multiFiltre(items, criteres=[]) {
    // On vérifie l'intégrité des données
    if(items === null)
        throw new Error("Une erreur s'est produite. Impossible d'effectuer de filtre ou de recherche sur un ensemble vide !");
    if(criteres === null)
        return;

    console.log("On commence la filtration");
    console.log("Liste des critères : ");
    console.log(criteres);

    // On déclare notre tableau de recherche
    let search = Array.from(items);

    // On applique les autres critères
    let i = 0;
    while(search !== null && i < criteres.length) {

        console.log("Echantillon à trier : ");
        console.log(search);
        console.log("Critère : ");
        console.log(criteres[i]);
        // On implémente l'échantillon
        switch(criteres[i].type) {
            case 'date':
                search = search.filter(item => filtrerParDate(item, criteres[i].index, criteres[i].criteres));
                break;
        
            case 'multi':
                search = search.filter(item => filterParCriteres(item, criteres[i].index, criteres[i].criteres));
                break;

            case 'default': 
                search = search.filter(item => filtrerPar(item, criteres[i].index, criteres[i].critere));
                break;

            default: 
                console.warn(`Critère invalide à l'index ${i}.`);
        }

        // On implémente le compteur
        i++;
    }

    return search;
}


// FONCTIONS DE TRIS //

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
    if (!items) 
        throw new Erreor('Tri impossible, items nul');
    if (index === null) 
        throw new Erreor('Tri impossible, index introuvable');
    if (index < 0) 
        throw new Erreor('Tri impossible, index négatif');
    if (items.length === 0) 
        throw new Erreor('Tri impossible, items vide');
    if (items[0].cells.length <= index) 
        throw new Erreor('Tri impossible, index supérieur à dimension items');

    // On vérifie le sens de tri
    if (typeof croissant !== 'boolean') 
        croissant = true;


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
    if (!croissant)
        search.reverse();
    
    // On retourne le résultat du tri
    return search;
}
