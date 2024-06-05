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
 * 
 * @param {*} parent 
 * @param {*} content 
 */
function createLine(parent=null, content=[]){
    if(parent === null || content.length === 0)
        return;

    // On génère la ligne
    const tr = document.createElement('tr');
    // On la remplit
    content.forEach(elmt => {
        const th = document.createElement('th');
        th.textContent = elmt.textContent;
        tr.append(th);
    });

    // On ajoute la ligne à son parent
    parent.appendChild(tr);
}
/**
 * @brief Fonction deconstruisant une ligne de tableau
 * @param {*} line La ligne
 * @returns 
 */
function destroyLine(line=null) {
    if(line === null)
        return;

    // On supprime l'élément
    line.remove();
}

/**
 * @brief Fonction construisant un tablea selon une entete et un contenu
 * @param {*} entete L'entête
 * @param {*} items Le contenu
 * @returns 
 */
function createTable(table=null, items=[]) {
    if(table === null |entete.length <= 0 || items.length <= 0 || entete.length < items.length)
        return;

    // On génère le corps du tableau
    const tbody = document.createElement('tbody');
    // On le remplit
    items.forEach(line => { createLine(tbody, line); });
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

    // On retire les lignes du tableau
    table.rows.forEach(line => { destroyLine(line) });
}