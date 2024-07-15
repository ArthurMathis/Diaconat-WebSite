<nav class="nav-barre" id="barre-de-navigation">
    <h1>Ypopsi</h1>
    <div class="section-logo">
        <div id="bouton-menu" class="LignesHover">
            <img  class="LignesHover"src="layouts\assets\img\logo\menu.svg" alt="Logo du menu, représenté par un burger">
        </div>
    </div>
</nav>
<section id="menu">
    <main>
        <header>
            <h1>Ypopsi</h1>
            <div id="bouton-close-menu" class="LignesHover"><img src="layouts\assets\img\logo\white-close.svg" alt="Logo de fermeture du menu, représenté par une croix"></div>
        </header>
        <content>
            <?php foreach($liste_menu as $item): ?>
                <article>
                    <a href="<?=$item["action"] ?>"><?=$item["intitule"] ?></a>
                    <img src="<?= $item["logo"] ?>">
                </article>
            <?php endforeach ?>
        </content>
        <img src="layouts/assets/img/coeur.png" alt="Illustration de coeur">
        <img src="layouts/assets/img/main.png" alt="Illustration de main">
    </main>
</section>

<script src="layouts\assets\scripts\views\entete.js"></script>