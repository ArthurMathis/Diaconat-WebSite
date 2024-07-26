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
        <section id="action_input" class="small-section">
            <p>Actions</p>
            <div class="container-statut">
                <input type="checkbox" name="connexion" checked>
                <p>Connexion</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="moderateur" checked>
                <p>Deconnexion</p>
            </div>
        </section>
        <section id="role_input" class="small-section">
            <p>Rôles</p>
            <div class="container-statut">
                <input type="checkbox" name="Administrateur" checked>
                <p>Administrateur</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Modérateur" checked>
                <p>Modérateur</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Utilisateur" checked>
                <p>Utilisateur</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Invité" checked>
                <p>Invité</p>
            </div>
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
    <button id="valider-filtre" class="circle_button">
        <img src="layouts\assets\img\logo\white-filtre.svg" alt="">
    </button>
</div>
<div class="candidatures-menu" id="rechercher-menu">
    <h2>Rechercher selon</h2>
    <content>
        <section>
            <p>Informations personnelles</p>
            <input type="text" id="recherche-nom"  placeholder="Nom">
            <input type="text" id="recherche-prenom" placeholder="Prenom">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>