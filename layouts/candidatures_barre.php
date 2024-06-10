<nav class="options_barre">
    <article>
        <a href="" class="LignesHover">Importer des candidatures</a>
        <a href="" class="LignesHover">Exporter des candidatures</a>
        <a href="index.php?candidatures=saisie-candidat" class="LignesHover">Saisir des candidatures</a>
    </article>
    <article>
        <!--<p id="trier-button" class="LignesHover">Trier</p>-->
        <p id="filtrer-button" class="LignesHover">Filtrer</p>
        <p id="rechercher-button" class="LignesHover">Rechercher</p>
    </article>
</nav>
<div class="candidatures-menu" id="filtrer-menu">
    <div id="statut_input">
        <h3>Statuts</h3>
        <div class="container-statut">
            <input type="checkbox" name="non-traitee" checked>
            <p>non-traitée</p>
        </div>
        <div class="container-statut">
            <input type="checkbox" name="en attente" checked>
            <p>en attente</p>
        </div>
        <div class="container-statut">
            <input type="checkbox" name="acceptee" checked>
            <p>acceptée</p>
        </div>
        <div class="container-statut">
            <input type="checkbox" name="refusee" checked>
            <p>refusée</p>
        </div>
    </div>
    <section>
        <input type="text" id="filtre-poste" placeholder="Poste">
        <input type="text" id="filtre-source" placeholder="Source">
    </section>
    <div class="input-date">
        <h3>Date minimale</h3>
        <input type="date" id="filtre-date-max" name="filre-data-max">
    </div>
    <div class="input-date">
        <h3>Date maximale</h3>
        <input type="date" id="filtre-date-min" name="filre-data-min">
    </div>
    <button id="valider-filtre">Appliquer</button>
</div>
<div class="candidatures-menu" id="rechercher-menu">
    <section>
        <input type="text" id="recherche-nom"  placeholder="Nom">
        <input type="text" id="recherche-prenom" placeholder="Prenom">
    </section>
    <section>
        <input type="text" id="recherche-email" placeholder="Email">
        <input type="text" id="recherche-telephone" placeholder="Telephone">
    </section>
    <button id="lancer-recherche">Lancer</button>
</div>