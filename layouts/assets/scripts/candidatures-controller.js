// On ajoute le code couleur !!
setColorStatut(candidatures, 0);
setColorDispo(candidatures, 7);
setColorSource(candidatures, 6);

// On ajoute le menu de filtration
let filtrerIsVisible = false;
filtrer.addEventListener('click', () => {
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
            document.getElementById('filtre-nom'),
            document.getElementById('filtre-prenom'),
            document.getElementById('filtre-poste'),
            document.getElementById('filtre-email'),
            document.getElementById('filtre-telephone'),
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

            // On vérifie la présence de critères
            if(criteres_statut.length === 0 && criteres.length === 0)
                // On réinitialise le tableau 
                resetLignes(candidatures);

            else {
                // On applique les filtres
                const res = multiFiltre(candidatures, criteres, criteres_statut, criteres_date);

                // On met à jour l'affichage
                retireLignes(candidatures);
                resetLignes(res);
                afficheNbItems(res !== null ? res.length : 0);

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