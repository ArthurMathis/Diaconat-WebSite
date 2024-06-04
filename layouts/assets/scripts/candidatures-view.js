// On ajoute le code couleur !!
setColor(candidatures, 0);

function resetLignes(items) {
    if(items == null)
        return ;

    for(let i = 0; i < items.length; i++) {
        items[i].style.display = 'table-row';
    }
}
function retireLignes(items) {
    if(items == null)
        return ;

    for(let i = 0; i < items.length; i++) {
        items[i].style.display = 'none';
    }
}

function montreMenu(item) { item.classList.add('active'); }
function cacheMenu(item) { item.classList.remove('active'); }