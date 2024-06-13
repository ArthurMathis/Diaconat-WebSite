<nav id="barre-de-navigation">
    <h1>Ypopsi</h1>
    <h2>Menu</h2>
</nav>
<section id="menu">
    <main>
        <div>
            <h1>Ypopsi</h1>
            <h2>Close</h2>
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

<script src="layouts\assets\scripts\entete-view.js"></script>
