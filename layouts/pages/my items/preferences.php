<aside>
    <article>
        <header>
            <img src="layouts\assets\img\logo\white-profil.svg" alt="Logo de la section profil représentant une personne">
            <h2>Votre compte</h2>
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "home") echo 'class="selected"'; ?> href="index.php?preferences=home">Consulter vos informations</a>
            <a <?php if($_GET['preferences'] == "edit-password") echo 'class="selected"'; ?> href="index.php?preferences=edit-password">Modifier votre mot de passe</a>
        </content>
    </article>
    <article>
        <header>
            <img src="layouts\assets\img\logo\white-utilisateurs.svg" alt="Logo de la section utilisateurs représentant un groupe de personne">
            <h2>Utilisateurs</h2>
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "liste-utilisateurs") echo 'class="selected"'; ?> href="index.php?preferences=liste-utilisateurs">Liste des utilisateurs</a>
            <a <?php if($_GET['preferences'] == "liste-nouveaux-utilisateurs") echo 'class="selected"'; ?> href="index.php?preferences=liste-nouveaux-utilisateurs">Nouveaux utilisateurs</a>
            <a <?php if($_GET['preferences'] == "connexion-historique") echo 'class="selected"'; ?> href="index.php?preferences=connexion-historique">Historique de connexions</a>
            <a <?php if($_GET['preferences'] == "action-historique") echo 'class="selected"'; ?> href="index.php?preferences=action-historique">Historique d'actions</a>
        </content>
    </article>
    <article>
        <header>
            <img src="layouts\assets\img\logo\white-data.svg" alt="Logo de la section données représentant un nuage">
            <h2>Données</h2>
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "liste-postes") echo 'class="selected"'; ?> href="index.php?preferences=liste-postes">Postes</a>
            <a <?php if($_GET['preferences'] == "liste-services") echo 'class="selected"'; ?> href="index.php?preferences=liste-services">Services</a>
            <a <?php if($_GET['preferences'] == "liste-etablissements") echo 'class="selected"'; ?> href="index.php?preferences=liste-etablissements">Etablissements</a>
            <a <?php if($_GET['preferences'] == "liste-poles") echo 'class="selected"'; ?> href="index.php?preferences=liste-poles">Pôles</a>
            <!--<a <?php if($_GET['preferences'] == "liste-diplomes") echo 'class="selected"'; ?> href="index.php?preferences=liste-diplomes">Diplômes</a>
            <a <?php if($_GET['preferences'] == "autres") echo 'class="selected"'; ?> href="index.php?preferences=autres">Autres</a>-->
        </content>
    </article>
</aside>