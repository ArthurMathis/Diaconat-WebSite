<nav class="options_barre">
    <article></article>
    <article>
        <p class="action_button" id="filtrer-button">Filtrer</p>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <h2>Filtrer par</h2>
    <content>
        <section class="action_statut">
            <p>Actions sur candidats</p>
            <div class="container-statut">
                <input type="checkbox" name="Nouveau candidat" checked>
                <p>Nouveau candidat</p>
            </div>
            <div class="container-statut margin">
                <input type="checkbox" name="Nouveau rendez-vous" checked>
                <p>Nouveau rendez-vous</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Mise-à-jour candidat" checked>
                <p>Mise-àjour candidat</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Mise-à-jour notation" checked>
                <p>Mise-à-jour notation</p>
            </div>
            <div class="container-statut margin">
                <input type="checkbox" name="Mise-à-jour rendez-vous" checked>
                <p>Mise-à-jour rendez-vous</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Annulation rendez-vous" checked>
                <p>Annulation rendez-vous</p>
            </div>
        </section>
        <section class="action_statut">
            <p>Actions sur candidatures</p>
            <div class="container-statut">
                <input type="checkbox" name="Nouvelle candidature" checked>
                <p>Nouvelle candidature</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Nouvelle proposition" checked>
                <p>Nouvelle proposition</p>
            </div>
            <div class="container-statut margin">
                <input type="checkbox" name="Nouveau contrat" checked>
                <p>Nouveau contrat</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Refus candidature" checked>
                <p>refus candidature</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Refus proposition" checked>
                <p>Refus proposition</p>
            </div>
            <div class="container-statut margin">
                <input type="checkbox" name="Démission" checked>
                <p>Démission</p>
            </div>
        </section>
        <section class="action_statut">
            <p>Actions sur la fondation</p>
            <div class="container-statut">
                <input type="checkbox" name="Nouveau poste" checked>
                <p>Nouveau poste</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Nouveau service" checked>
                <p>Nouveau service</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Nouveau établissement" checked>
                <p>Nouveau établissement</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Nouveau pôle" checked>
                <p>Nouveau pôle</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Nouveau diplome" checked>
                <p>Nouveau diplome</p>
            </div>
        </section>
        <section class="action_statut">
            <p>Actions sur utilisateurs</p>
            <div class="container-statut">
                <input type="checkbox" name="Nouvel utilisateur" checked>
                <p>Nouvel utilisateur</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Mise-à-jour utilisateur" checked>
                <p>Mise-à-jour utilisateur</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Mise-à-jour mot de passe" checked>
                <p>Mise-à-jour mot de passe</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Réinitialisation mot de passe" checked>
                <p>Réinitialisation mot de passe</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Mise-à-jour rôle" checked>
                <p>Mise-à-jour rôle</p>
            </div>
        </section>
    </content>    
    <button id="valider-filtre" class="circle_button">
        <img src="layouts\assets\img\logo\white-filtre.svg" alt="">
    </button>
</div>
<div class="candidatures-menu" id="rechercher-menu">
    <h2>Rechercher selon</h2>
    <content>
        <section>
            <p>Informations personnelles</p>
            <input type="text" id="recherche-utilisateur"  placeholder="Utilisateur">
        </section>
        <section>
            <p>Date minimale</p>
            <input type="date" id="filtre-date-max" name="filre-data-max">
        </section>
        <section>
            <p>Date maximale</p>
            <input type="date" id="filtre-date-min" name="filre-data-min">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>