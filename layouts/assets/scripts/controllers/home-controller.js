const source = '.liste_items .table-wrapper table tbody';

// On récupère le tableau de candidatures
let candidatures = recupCandidatures(source);
const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);

// On définit les variables tampons
let item_clicked = null;
let method_tri = true;

entete.forEach((item, index) => {
    item.addEventListener('click', () => {
        method_tri = !method_tri;
        // On effectue le tri
        if(item_clicked != index)
            method_tri = true;
        const candidatures_triees = trierSelon(candidatures, index, method_tri);
        item_clicked = index;

        // On cherche les éventuelles erreurs
        if(candidatures_triees == null || candidatures_triees.length === 0)
            alert("Alerte : Tri non executé.");
        
        else {
            // On déconstruit et reconstruit le tableau
            destroyTable(document.querySelector('.liste_items .table-wrapper table tbody'));
            createTable(document.querySelector('.liste_items .table-wrapper table'), candidatures_triees);
            // On recharge le tableau dans le script
            candidatures = recupCandidatures(source)
            
            // On déselectionne les entetes
            entete.forEach(items => {
                items.classList.remove('active');
                items.classList.remove('reverse-tri');
            });
            item.classList.add('active');
            if(method_tri)
                item.classList.add('reverse-tri');
            else item.classList.remove('reverse-tri');
        }

    });
});

// On ajoute la Liste dynamique //

const liste = new Liste("main-liste");


console.log(candidatures);
console.log(entete);
console.log(window.innerWidth)
const sizes = [
    {
        width: 1700,
        indexs: [3]
    }, 
    {
        width: 1400,
        indexs: [4]
    },
    {
        width: 1200,
        indexs: [5]
    }
];
window.onresize = function() { responsive(window.innerWidth, entete, candidatures, sizes) };
responsive(window.innerWidth, entete, candidatures, sizes);