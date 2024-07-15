<?php if(!empty($liste_menu)): ?>
    <nav class="form-barre" id="barre-de-navigation">
        <img id="illustration_bulle" src="layouts/assets/img/bulle.svg">
        <h1>Ypopsi</h1>
        <div class="section-logo">
            <a class="LignesHover" href="index.php">
                <img  src="layouts\assets\img\logo\home.svg" alt="Logo de la page d'accueil, représenté par une maison">
            </a>
            <div id="bouton-menu" class="LignesHover">
                <img  class="LignesHover"src="layouts\assets\img\logo\menu.svg" alt="Logo du menu, représenté par un burger">
            </div>
        </div>
    </nav>
    <section id="menu">
        <main>
            <div>
                <h1>Ypopsi</h1>
                <h2 class="LignesHover">Close</h2>
            </div>
            <content>
                <?php foreach($liste_menu as $item): ?>
                    <a href="<?=$item["action"] ?>"><?=$item["intitule"] ?></a>
                <?php endforeach ?>
            </content>
            <img src="layouts/assets/img/coeur.png" alt="Illustration de coeur">
            <img src="layouts/assets/img/main.png" alt="Illustration de main">
        </main>
    </section>
                
    <script src="layouts\assets\scripts\views\entete.js"></script>
<?php else: ?>    
    <nav class="form-barre">
        <img id="illustration_bulle" src="layouts/assets/img/bulle.svg">
        <h1>Ypopsi</h1> 
        <div class="section-logo">
            <a class="LignesHover" href="index.php">
                <img  src="layouts\assets\img\logo\home.svg" alt="Logo de la page d'accueil, représenté par une maison">
            </a>
        </div>
    </nav>
<?php endif ?> 