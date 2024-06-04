let filtrerIsVisible = false;
console.log(filtrerIsVisible);
filtrer.addEventListener('click', () => {
    if(filtrerIsVisible) {
        // On libère les champs 
        const status = null;
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
        const status = document.getElementById('status');
        const nom = document.getElementById('nom');
        const prenom = document.getElementById('prenom');
        const poste = document.getElementById('poste');
        const email = document.getElementById('email');
        const telephone = document.getElementById('telephone');
        const source = document.getElementById('source');

        const champs = [
            document.getElementById('filtre-status'),
            document.getElementById('filtre-nom'),
            document.getElementById('filtre-prenom'),
            document.getElementById('filtre-poste'),
            document.getElementById('filtre-email'),
            document.getElementById('filtre-telephone'),
            document.getElementById('filtre-source'),
        ]

        // On recupère le bouton de recherche
        const bouton = document.getElementById('valider-recherche');

        bouton.addEventListener('click', () => {
            // On déclare la liste de critères
            const criteres = [];
            // On recupère le contenu des champs
            recupChamps(champs, criteres);

            console.log("Dimension du tableau" + criteres.length);

            // On vérifie la présence des données
            if(criteres.length == 0) 
                resetLignes(candidatures);

            // On recherche les éléments
            multiFiltre(candidatures, criteres);
            // On cache le menu
            filtrerIsVisible = !filtrerIsVisible;
            cacheMenu(filtrer_menu);
        });

        // On affiche le menu
        montreMenu(filtrer_menu);
    }

    // On implémente
    filtrerIsVisible = !filtrerIsVisible;
    console.log(filtrerIsVisible);
});

