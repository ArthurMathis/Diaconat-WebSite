<nav class="barre-de-navigation">
    <div id="menu-icon">
        <span></span>
    </div>
    <img src="assets/img/ico_diaconat_mulhouse.webp" alt="Logo de l'application">
    <div>
        <p id="calendrier"></p>
        <p id="horloge">00 : 00 : 00</p>
        <p class="user-info"><?php echo $_SESSION["user_identifiant"]; ?></p>
    </div>
</nav>
<form id="menu-deconnexion" method="POST" action="">
    <button type="submit" class="LignesHover">Se déconnecter</button>
</form>
<section id="menu">
    <a href="#">Candidatures</a>
    <a href="#">Employés</a>
    <a href="#">Besoins</a>
    <a href="#">Statistiques</a>
    <a href="#">Préférences</a>
</section> 

<script src="layouts\assets\scripts\objects\Date_Time.js"></script>
<script src="layouts\assets\scripts\view.js"></script>