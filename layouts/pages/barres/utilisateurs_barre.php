<nav class="options_barre">
    <article>
        <a class="action_button reverse_color" href="index.php?utilisateurs=logs">Historique de connexion</a>
        <a class="action_button" href="index.php?utilisateurs=saisie-inscription">Nouvel utilisateur</a>
    </article>
    <article>
        <p class="action_button" id="filtrer-button">Filtrer</p>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <div id="statut_input">
        <h3>Rôles</h3>
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
    </div>
    <section>
        <input type="text" id="filtre-etablissement" placeholder="Etablissement">
    </section>
    <button id="valider-filtre">Appliquer</button>
</div>
<div class="candidatures-menu" id="rechercher-menu">
    <section>
        <input type="text" id="recherche-nom"  placeholder="Nom">
        <input type="text" id="recherche-prenom" placeholder="Prenom">
    </section>
    <section>
        <input type="text" id="recherche-email" placeholder="Email">
    </section>
    <button id="lancer-recherche">Lancer</button>
</div>