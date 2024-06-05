// On ajoute le code couleur !!
setColor(candidatures, 0);

// On ajoute le menu de filtration
let filtrerIsVisible = false;
filtrer.addEventListener('click', () => {
    if(filtrerIsVisible) {
        // On libère les champs 
        const statut = null;
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
            document.getElementById('filtre-statut'),
            document.getElementById('filtre-nom'),
            document.getElementById('filtre-prenom'),
            document.getElementById('filtre-poste'),
            document.getElementById('filtre-email'),
            document.getElementById('filtre-telephone'),
            document.getElementById('filtre-source'),
        ];

        // On recupère le bouton de recherche
        const bouton = document.getElementById('valider-filtre');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On déclare la liste de critères
            const criteres = [];
            // On recupère le contenu des champs
            recupChamps(champs, criteres);

            if(criteres.length === 0)
                // On réinitialise le tableau 
                resetLignes(candidatures);

            else {
                // On applique les filtres
                multiFiltre(candidatures, criteres);

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