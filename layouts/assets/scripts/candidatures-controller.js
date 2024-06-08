// On récupère les boutons
const rechercher = document.getElementById('rechercher-button');
const filtrer = document.getElementById('filtrer-button');
const trier = document.getElementById('rechercher-button');

// On recupère les formulaires
const rechercher_menu = document.getElementById('rechercher-menu');
const filtrer_menu = document.getElementById('filtrer-menu');
const trier_menu = document.getElementById('trier-menu');

// On ajoute le code couleur !!
setColorStatut(candidatures, 0);
setColorSource(candidatures, 6);
setColorDispo(candidatures, 7);

// On duplique le tableau pour travailler plus simplement
let candidatures_selection = Array.from(candidatures);

// On ajoute le menu de filtration
let filtrerIsVisible = false;
filtrer.addEventListener('click', () => {
    // On cache l'autre fomulaire
    cacheMenu(rechercher_menu);

    if(filtrerIsVisible) {
        champs = null;
        champs_statut = null;
        champs_date = null;

        // On cache le formulaire
        cacheMenu(filtrer_menu);

    } else {
        // On récupère les champs du formulaire
        const champs_statut = document.getElementById('statut_input').querySelectorAll('input');
        const champs_infos = [
            document.getElementById('filtre-poste'),
            document.getElementById('filtre-source'),
        ];
        const champs_date = [
            document.getElementById('filtre-date-max'),
            document.getElementById('filtre-date-min')
        ];

        // On recupère le bouton de recherche
        const bouton = document.getElementById('valider-filtre');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On récupère la liste de critères
            const criteres = recupChamps(champs_infos);
            const criteres_statut = recupChampsStatut(champs_statut);
            const criteres_date = recupChapsDate(champs_date);


            console.log(criteres.length);
            console.log(criteres_statut);
            console.log(criteres_date.Criteres);

            // On vérifie la présence de critères
            if(criteres.length === 0  && criteres_statut.criteres.length === 4 && criteres_date === null) {
                // On réinitialise le tableau 
                resetLignes(candidatures);
                candidatures_selection = Array.from(candidatures);
                afficheNbItems(candidatures !== null ? candidatures.length : 0);

            } else {
                // On applique les filtres
                candidatures_selection = multiFiltre(candidatures_selection, criteres, criteres_statut, criteres_date);

                // On met à jour l'affichage
                retireLignes(candidatures);
                resetLignes(candidatures_selection);
                afficheNbItems(candidatures_selection !== null ? candidatures_selection.length : 0);

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

// On ajoute le menu de filtration
let rechercherIsVisible = false;
rechercher.addEventListener('click', () => {
    // On cache l'autre fomulaire
    cacheMenu(filtrer_menu);

    if(rechercherIsVisible) {
        champs = null;
        champs_statut = null;
        champs_date = null;

        // On cache le formulaire
        cacheMenu(rechercher_menu);

    } else {
        // On récupère les champs du formulaire
        const champs_infos = [
            document.getElementById('recherche-nom'),
            document.getElementById('recherche-prenom'),
            document.getElementById('recherche-email'),
            document.getElementById('recherche-telephone')
        ];

        // On recupère le bouton de recherche
        const bouton = document.getElementById('lancer-recherche');

        // Nettoyer les anciens gestionnaires d'événements pour éviter les ajouts multiples
        const newBouton = bouton.cloneNode(true);
        bouton.parentNode.replaceChild(newBouton, bouton);

        newBouton.addEventListener('click', () => {
            // On récupère la liste de critères
            const criteres = recupChamps(champs_infos);

            // On vérifie la présence de critères
            if(criteres.length === 0) {
                // On réinitialise le tableau 
                resetLignes(candidatures);
                candidatures_selection = Array.from(candidatures);
                afficheNbItems(candidatures !== null ? candidatures.length : 0);

            } else {
                // On applique les filtres
                candidatures_selection = multiFiltre(candidatures_selection, criteres);

                // On met à jour l'affichage
                retireLignes(candidatures);
                resetLignes(candidatures_selection);
                afficheNbItems(candidatures_selection !== null ? candidatures_selection.length : 0);

                // On cache le menu
                rechercherIsVisible = !rechercherIsVisible;  
            }
            
            // On cache le menu
            cacheMenu(rechercher_menu);
        });

        // On affiche le menu
        montreMenu(rechercher_menu);
    }
    rechercherIsVisible = !rechercherIsVisible;
});