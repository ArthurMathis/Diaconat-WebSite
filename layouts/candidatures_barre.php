<nav class="options_barre">
    <article>
        <form class="link-form"method="post" action=""><button type="submit">Importer des candidatures</button></form>
        <form class="link-form"method="post" action=""><button type="submit">Exporter des candidatures</button></form>
        <form class="link-form"method="post" action=""><button type="submit">Saisir des candidatures</button></form>
    </article>
    <article>
        <p id="filtrer-button"      class="LignesHover">Filtrer</p>
        <p id="rechercher-button"   class="LignesHover">Rechercher</p>
        <!--<p id="trier-button"        class="LignesHover">Trier</p>-->
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
            <input type="checkbox" name="accpetee" checked>
            <p>acceptée</p>
        </div>
        <div class="container-statut">
            <input type="checkbox" name="refusee" checked>
            <p>refusée</p>
        </div>
    </div>
    <section>
        <input type="text" id="filtre-nom"  placeholder="Nom">
        <input type="text" id="filtre-prenom" placeholder="Prenom">
    </section>
    <section>
        <input type="text" id="filtre-email" placeholder="Email">
        <input type="text" id="filtre-telephone" placeholder="Telephone">
    </section>
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
<div class="candidatures-menu" id="Rechercher-menu" style="display: none"></div>
<div class="candidatures-menu" id="trier-menu"      style="display: none"></div>