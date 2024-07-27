/**
 * @brief Fonction affichant les éléments d'un tableau
 * @param {*} items Le tableau à afficher
 * @returns 
 */
function resetLignes(items) {
    if(items === null)
        return ;

    for(let i = 0; i < items.length; i++) 
        items[i].style.display = 'table-row';
}
/**
 * @brief Fonction cachant les ignes d'un tableau
 * @param {*} items Les lignes à cacher
 * @returns 
 */
function retireLignes(items) {
    if(items === null)
        return ;

    for(let i = 0; i < items.length; i++) 
        items[i].style.display = 'none';
}
/**
 * @brief Fonction affichant le nombre d'items présents dans le tableau
 * @param {*} nb_items Le nombre d'éléments présents
 * @returns 
 */
function afficheNbItems(item, nb_items) {
    if(item === null || !Number.isInteger(nb_items))
        return;

    item.innerHTML = nb_items;
}

/**
 * @brief Fonction affichant un menu
 * @param {*} item Le menu
 */
function montreMenu(item) { item.classList.add('active'); }
/**
 * @brief Fonction cachant un menu
 * @param {*} item Le menu
 */
function cacheMenu(item) { item.classList.remove('active'); }


function showHeader(items, index) {
    // On affiche la case
    Array.from(items).forEach((cell, i) => {
        if (i == index) 
            cell.style.display = '';
    });
}
function hideHeader(items, index) {
    // On cache la case
    Array.from(items).forEach((cell, i) => {
        if (i == index) 
            cell.style.display = 'none';
    });
}
/**
 * @brief Fonction montrant une colonne du tableau
 * @param {*} items Le tableau 
 * @param {*} index La colonne
 */
function showColumn(items, index) {
    // On fait défiler les lignes du tableau 
    Array.from(items).forEach(row => {
        // On fait défiler les cases de la ligne
        Array.from(row.cells).forEach((cell, i) => {
            // On affiche la case
            if (i == index) 
                cell.style.display = '';
        });
    }); 
}
/**
 * @brief Fonction cachant une colonne du tableau
 * @param {*} items Le tableau 
 * @param {*} index La colonne à masquer
 */
function hideColumn(items, index) {
    // On fait défiler les lignes du tableau 
    Array.from(items).forEach(row => {
        // On fait défiler les cases de la ligne
        Array.from(row.cells).forEach((cell, i) => {
            // On cache la case
            if (i == index) 
                cell.style.display = 'none';
        });
    });
}
/**
 * @brief Fonction cachant ou affichant les colonnes du tableau html selon le besoin du responsive
 * @param {*} width La largeur de la fenêtre
 * @param {*} entete L'entête du tableau 
 * @param {*} items Le contenu du tableau
 * @param {*} sizes La liste des indexs
 */    
function responsive(width, entete, items, sizes) {
    sizes.forEach(size => {
        if (width <= size.width) {
            size.indexs.forEach(index => { 
                hideHeader(entete, index);
                hideColumn(items, index); 
            });
        } else {
            size.indexs.forEach(index => { 
                showHeader(entete, index);
                showColumn(items, index); 
            });
        }
    });
}


/**
 * @brief Fonction construisant un tablea selon une entete et un contenu
 * @param {*} entete L'entête
 * @param {*} items Le contenu
 * @returns 
 */
function createTable(table=null, items=[]) {
    if(table === null || items.length <= 0)
        return;

    // On génère le corps du tableau
    const tbody = document.createElement('tbody');
    // On le remplit
    items.forEach(line => { 
        tbody.append(line); 
    });
    // On l'ajoute au tableau
    table.appendChild(tbody);
}
/**
 * @brief Fonction deconstruisant un tableau
 * @param {*} table Le tableau
 * @returns 
 */
function destroyTable(table=null) {
    if(table === null)
        return;

    table.remove();
}