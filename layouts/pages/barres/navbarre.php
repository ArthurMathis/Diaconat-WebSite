<?php if($form): ?>
    <nav class="form-barre" id="barre-de-navigation">
        <img id="illustration_bulle" src="layouts/assets/img/bulle.svg">
<?php else: ?>
    <nav class="nav-barre" id="barre-de-navigation">
<?php endif ?>            
    <h1>Ypopsi</h1>
    <div class="section-logo">
        <a class="LignesHover" href="index.php" <?php if($home == false) :?>style="display: none"<?php endif; ?>>
            <img  src="layouts\assets\img\logo\home.svg" alt="Logo de la page d'accueil, représenté par une maison">
        </a>
        <div id="bouton-menu" class="LignesHover"<?php if($menu == false): ?>style="display: none"<?php endif; ?>>
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