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
        <section id="action_input">
            <p>Actions</p>
            <div class="container-statut">
                <input type="checkbox" name="Nouvel utilisateur" checked>
                <p>Nouvel utilisateur</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Modification de mot de passe" checked>
                <p>Modification de mot de passe</p>
            </div>
            <div class="container-statut margin">
                <input type="checkbox" name="Nouveau candidat" checked>
                <p>Nouveau candidat</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Nouvelle candidature" checked>
                <p>Nouvelle candidature</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Nouvelle proposition" checked>
                <p>Nouvelle proposition</p>
            </div>
            <div class="container-statut margin">
                <input type="checkbox" name="Nouveau Contrat" checked>
                <p>Nouveau Contrat</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Refus d'une candidature" checked>
                <p>Refus d'une candidature</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Refus d'une proposition" checked>
                <p>Refus d'une proposition</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Refus d'un contrat" checked>
                <p>Refus d'un contrat</p>
            </div>
            <div class="container-statut">
                <input type="checkbox" name="Démission d'un contrat" checked>
                <p>Démission d'un contrat</p>
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
            <input type="text" id="recherche-utilisateur"  placeholder="Utilisateur">
        </section>
    </content>
    <button id="lancer-recherche" class="circle_button">
        <img src="layouts\assets\img\logo\white-recherche.svg" alt="">
    </button>
</div>