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

    console.log(items);

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

    // On retourne le résultat du filtre
    return item.cells[index].textContent.trim() === critere;

    // On récupère les différentes cellules de la ligne
    // const obj = item.cells;
    // 
    // console.log("Item : " + obj[index].textContent.trim());
    // 
    // return obj[index].textContent.trim() === critere;
}
/**
 * @brief Fonction permettant de filtrer un tableau selon un filtre à plusieurs critères
 * @param {*} item La ligne du tableau
 * @param {*} index La colonne dans laquelle on effectue le filtre
 * @param {*} criteres La liste des valeurs recherchées
 */
function filterParCriteres(item, index, criteres=[]) {
    if (index < 0 || index >= item.cells.length) 
        throw new Error("Impossible d'appliquer le filtre. Indice de invalide !");

    // On fait défiler les criteres
    let i = 0, find = false;
    while(!find && i < criteres.length) {
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
                throw new Error("Critère non reconnu : " + critere_date[i]);
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
function multiFiltre(items, criteres = [], criteres_statut=null, criteres_date=null) {
    if (items === null || (criteres_statut !== null && criteres_statut.index < 0) || (criteres_date !== null && criteres_date.index < 0)) 
        throw new Error("Erreur lors de la recherche par filtre. Les listes de critères sont incohérentes.");

    // On déclare notre tableau de recherche
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
