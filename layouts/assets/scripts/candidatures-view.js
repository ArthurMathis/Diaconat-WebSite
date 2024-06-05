function resetLignes(items) {
    if(items === null)
        return ;

    console.log('On affiche les éléments: ');
    console.table(items);

    for(let i = 0; i < items.length; i++) 
        items[i].style.display = 'table-row';
}
function retireLignes(items) {
    if(items === null)
        return ;

    console.log('On retire les éléments: ');
    console.table(items);

    for(let i = 0; i < items.length; i++) 
        items[i].style.display = 'none';
}
function afficheNbItems(nb_items) {
    if(!Number.isInteger(nb_items))
        return;

    nb_candidatures.innerHTML = nb_items;
}

function montreMenu(item) { item.classList.add('active'); }
function cacheMenu(item) { item.classList.remove('active'); }