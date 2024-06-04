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

        bouton.addEventListener('click', () => {
            // On réinitialise le tableau 
            resetLignes(candidatures);

            setTimeout(() => {
                // On déclare la liste de critères
                const criteres = [];
                // On recupère le contenu des champs
                recupChamps(champs, criteres);

                // On vérifie la présence des données
                if(criteres === null) 
                    console.log("Il n'y a pas de critères")
                    // resetLignes(candidatures);

                // On recherche les éléments
                multiFiltre(candidatures, criteres);
                // On cache le menu
                filtrerIsVisible = !filtrerIsVisible;
                cacheMenu(filtrer_menu);
            }, 100);
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