<nav class="options_barre">
    <article>
        <a class="action_button reverse_color" href="index.php?preferences=saisie-utilisateur">Nouvel utilisateur</a>
    </article>
    <article>
        <p class="action_button" id="filtrer-button">Filtrer</p>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <h2>Filtrer par</h2>
    <content>
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
            <p>Etablissement</p>
            <input type="text" id="filtre-etablissement" placeholder="Etablissement">
        </section>
    </content>
    <button id="valider-filtre" class="circle_button">
        <img src="layouts\assets\img\logo\white-filtre.svg" alt="">
    </button>
</div>
<div class="candidatures-menu" id="rechercher-menu">
    <h2>Rechercher par</h2>
    <content>
        <section>
            <input type="text" id="recherche-nom"  placeholder="Nom">
            <input type="text" id="recherche-prenom" placeholder="Prenom">
        </section>
        <section>
            <input type="text" id="recherche-email" placeholder="Email">
            <input type="text" id="recherche-telephone" placeholder="Telephone">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>