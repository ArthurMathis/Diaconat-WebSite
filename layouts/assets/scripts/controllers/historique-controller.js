// On récupère le tableau de candidatures
let candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
const entete = Array.from(document.querySelector('.liste_items .table-wrapper table thead tr').cells);

// On ajoute le système de tri //

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
            candidatures = document.querySelector('.liste_items .table-wrapper table tbody').rows
            
            // On déselectionne les entetes
            entete.forEach(items => {
                items.classList.remove('active');
                items.classList.remove('reverse-tri');
            });
            item.classList.add('active');
            if(method_tri)
                item.classList.add('reverse-tri');
            else 
                item.classList.remove('reverse-tri');
        }
    });
});



// On ajoute la Liste dynamique //

const liste = new Liste("main-liste");



// On ajoute les codes couleurs
setColor(candidatures, [
    {
        content: 'Connexion', 
        class: 'connexion'
    },{
        content: 'Deconnexion', 
        class: 'deconnexion'
    }
], 0);
setColor(candidatures, [
    {
        content: 'Administrateur', 
        class: 'administrateur'
    },
    {
        content: 'Modérateur', 
        class: 'moderateur'
    },
    {
        content: 'Utilisateur', 
        class: 'utilisateur'
    },{
        content: 'Invité', 
        class: 'invite'
    }
], 1);