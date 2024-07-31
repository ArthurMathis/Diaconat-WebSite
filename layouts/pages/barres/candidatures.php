<nav class="options_barre">
    <article>
        <a class="action_button reverse_color" href="index.php?candidats=home">Liste des candidats</a>
        <?php if($_SESSION['user_role'] != INVITE): ?>
            <a class="action_button" href="index.php?candidatures=saisie-nouveau-candidat">Nouvelle candidature</a>
        <?php endif ?>    
    </article>
    <article>
        <p class="action_button" id="filtrer-button">Filtrer</p>
        <p class="action_button" id="rechercher-button">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <h2>Filtrer par</h2>
    <content>
        <section id="statut_input" class="small-section">
            <p>Statuts</p>
            <div class="container-statut">
                <input type="checkbox" name="Non-traitée" checked>
                <p>Non-traitée</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Acceptée" checked>
                <p>Acceptée</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Refusée" checked>
                <p>Refusée</p>
            </div>
        </section>
        <section>
            <p>Postes et sources</p>
            <input type="text" id="filtre-poste" placeholder="Poste">
            <input type="text" id="filtre-source" placeholder="Source">
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
    <h2>Rechercher par</h2>
    <content>
        <section>
            <p>Informations personnelles</p>
            <input type="text" id="recherche-nom"  placeholder="Nom">
            <input type="text" id="recherche-prenom" placeholder="Prenom">
        </section>
        <section>
            <p>Informations de communication</p>
            <input type="text" id="recherche-email" placeholder="Email">
            <input type="text" id="recherche-telephone" placeholder="Telephone">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>