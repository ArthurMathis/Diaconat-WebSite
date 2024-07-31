<nav class="options_barre">
    <article>
        <?php if($_SESSION['user_role'] == OWNER || $_SESSION['user_role'] == ADMIN): ?>
            <a class="action_button reverse_color" href="index.php?preferences=saisie-etablissement">Nouvel établissement</a>
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
        <section id="pole_input" class="small-section">
            <p>Pôles</p>
            <div class="container-statut">
                <input type="checkbox" name="pspdna" checked>
                <p>pspdna</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="pspdca" checked>
                <p>pspdca</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="pspdsa" checked>
                <p>pspdsa</p>
            </div>
        </section>
        <section>
            <p>Locatisation</p>
            <input type="text" id="filtre-ville" placeholder="Ville">
            <input type="text" id="filtre-code" placeholder="Code Postal">
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
            <input type="text" id="recherche-etablisseement"  placeholder="Intitulé">
            <input type="text" id="recherche-adresse" placeholder="Adresse">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>