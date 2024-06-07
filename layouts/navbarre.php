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
            <!--<form class="link-form" method="post" action ="<?=$item["action"] ?>"><button type="submit"><?=$item["intitule"] ?></button></form>-->
            <a href="<?=$item["action"] ?>"><?=$item["intitule"] ?></a>
        <?php endforeach ?>
    </content>
    </main>
</section>

<script src="layouts\assets\scripts\entete-view.js"></script>
