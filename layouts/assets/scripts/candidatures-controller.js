// On ajoute le code couleur !!
setColor(candidatures, 0);

// On ajoute le menu de filtration
let filtrerIsVisible = false;
filtrer.addEventListener('click', () => {
    if(filtrerIsVisible) {
        // On libère les champs 
        const nom = null;
        const prenom = null;
        const poste = null;
        const email = null;
        const telephone = null;
        const source = null;

        // On cache le formulaire
        cacheMenu(filtrer_menu);

    } else {
        // On récupère les champs du formulaire
        const champs = [
            document.getElementById('filtre-nom'),
            document.getElementById('filtre-prenom'),
            document.getElementById('filtre-poste'),
            document.getElementById('filtre-email'),
            document.getElementById('filtre-telephone'),
            document.getElementById('filtre-source'),
        ];
        const champs_statut = document.getElementById('statut_input').querySelectorAll('input');

        // On recupère le bouton de recherche
        const bouton = document.getElementById('valider-filtre');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On récupère la liste de critères
            const criteres = recupChamps(champs);
            // On récupère les statut acceptés dans la recherche
            const criteres_statut = recupChampsStatut(champs_statut);

            // On vérifie la présence de critères
            if(criteres_statut.length === 0 && criteres.length === 0)
                // On réinitialise le tableau 
                resetLignes(candidatures);

            else {
                // On applique les filtres
                multiFiltre(candidatures, criteres, criteres_statut, 0);

                // On cache le menu
                filtrerIsVisible = !filtrerIsVisible;
                cacheMenu(filtrer_menu);
            }
        });

        // On affiche le menu
        montreMenu(filtrer_menu);
    }
    filtrerIsVisible = !filtrerIsVisible;
});

const tab1 = [1, 2, 3, 4];
const tab2 = [4, 5, 6, 7];
const tab = tab1.concat(tab2);
console.table(tab);