<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaconat - Gestionnaire de candidatures</title>

    <link rel="stylesheet" href="stylesheet/styles.css">
    <link rel="stylesheet" href="stylesheet/index.css">
</head>
<body>
    <nav class="barre-de-navigation">
        <div id="menu-icon">
            <span></span>
        </div>
        <img src="assets/ico_diaconat_mulhouse.webp" alt="Logo de l'application">
        <div>
            <p id="calendrier"></p>
            <p id="horloge"></p>
            <p>Mathis Arthur</p>
        </div>
    </nav>
    <section id="menu">
        <a href="#">Candidatures</a>
        <a href="#">Employés</a>
        <a href="#">Besoins</a>
        <a href="#">Statistiques</a>
        <a href="#">Préférences</a>
    </section>
    <content>
        <section></section>
        <aside>
            <article>
                <div class="entete">
                    <h2>Candidatures en attente</h2>
                    <h2>6</h2>
                </div>
                <span class="ligne">
                <div class="container">
                    <div class="item">
                        <p>Mathis</p>
                        <p>Jean-françois</p>
                        <p>Accuponcteur-homéopathe</p>
                    </div>
                    <div class="item">
                        <p>Deroussin</p>
                        <p>Esteban</p>
                        <p>Directeur artisique, UX/UI design</p>
                    </div>
                    <div class="item">
                        <p>Bouadballah</p>
                        <p>Narimane</p>
                        <p>Ingénieur en intelligence artificielle</p>
                    </div>
                    <div class="item">
                        <p>Mathis</p>
                        <p>Stéphanie</p>
                        <p>Médecin coordinateur et gériatre</p>
                    </div>
                </div>
                <div class="boutons">
                    <a href="">+</a>
                    <a href="">Consulter</a>
                </div>
                
            </article>
            <article></article>
            <article></article>
            <article></article>
        </aside>
    </content>

    <script src="scripts\data.js"></script>
    <script src="scripts\view.js"></script>
</body>
</html>