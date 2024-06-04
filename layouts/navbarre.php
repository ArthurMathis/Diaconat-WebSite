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
        <form class="link-form" method="post" action ="<?=$item["action"] ?>"><button type="submit"><?=$item["intitule"] ?></button></form>
    <?php endforeach ?>
</section>
<!--
<section id="menu">
    <form class="link-form" method="post" action ="index.php"><button type="submit">Home</button></form>
    <form class="link-form" method="post" action ="index.php?candidatures=home"><button type="submit">Candidatures</button></form>
    <form class="link-form" method="post" action =""><button type="submit">Employés</button></form>
    <form class="link-form" method="post" action =""><button type="submit">Besoins</button></form>
    <form class="link-form" method="post" action =""><button type="submit">Statistiques</button></form>
    <form class="link-form" method="post" action =""><button type="submit">Préférences</button></form>
    <form class="link-form" method="post" action ="index.php?login=deconnexion"><button type="submit">Se déconnecter</button></form>
</section> 
-->
<script src="layouts\assets\scripts\objects\Date_Time.js"></script>
<script src="layouts\assets\scripts\entete-view.js"></script>