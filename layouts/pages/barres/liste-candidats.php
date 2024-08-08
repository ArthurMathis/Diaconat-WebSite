<nav class="options_barre">
    <article>
        <a class="action_button reverse_color" href="index.php?candidatures=home">Liste des candidatures</a>
    </article>
    <article>
        <p class="action_button" id="filtrer-button">Filtrer</p>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <h2>Filtrer par</h2>
    <content>
        <section>
            <p>Informations relatives au poste</p>
            <input type="text" id="filtre-ville" placeholder="Ville">
            <input type="text" id="filtre-source" placeholder="Notation">
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
        <section>
            <p>Information de communication</p>
            <input type="text" id="recherche-email" placeholder="Email">
            <input type="text" id="recherche-telephone" placeholder="Telephone">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>