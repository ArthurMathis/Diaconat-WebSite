/**
 * @brief Fonction affichant les éléments d'un tableau
 * @param {*} items Le tableau à afficher
 * @returns 
 */
function resetLignes(items) {
    if(items === null)
        return ;

    console.log('On affiche les éléments: ');
    console.table(items);

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

    console.log('On retire les éléments: ');
    console.table(items);

    for(let i = 0; i < items.length; i++) 
        items[i].style.display = 'none';
}

/**
 * @brief Fonction affichant le nombre d'items présents dans le tableau
 * @param {*} nb_items Le nombre d'éléments présents
 * @returns 
 */
function afficheNbItems(nb_items) {
    if(!Number.isInteger(nb_items))
        return;

    nb_candidatures.innerHTML = nb_items;
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
    console.log('On ajoute les lignes :');
    // On le remplit
    items.forEach(line => { 
        console.log(line);
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