<nav class="barre-de-navigation">
    <div id="menu-icon">
        <span></span>
    </div>
    <nav class="title">
        <img src="layouts\assets\img\ico_diaconat_mulhouse.webp" alt="Logo de l'application">
        <p>Ypopsi</p>
</nav>
    <div>
        <p id="calendrier"></p>
        <p id="horloge">00 : 00 : 00</p>
        <p class="user-info"><?php echo $_SESSION["user_identifiant"]; ?></p>
    </div>
</nav>
<section id="menu">
    <?php foreach($liste_menu as $item): ?>
        <!--<form class="link-form" method="post" action ="<?=$item["action"] ?>"><button type="submit"><?=$item["intitule"] ?></button></form>-->
        <a class="LignesHover" href="<?=$item["action"] ?>"><?=$item["intitule"] ?></a>
    <?php endforeach ?>
</section>
<script src="layouts\assets\scripts\objects\Date_Time.js"></script>
<script src="layouts\assets\scripts\entete-view.js"></script>