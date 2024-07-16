<aside>
    <article>
        <header>
            <img src="layouts\assets\img\logo\white-profil.svg" alt="Logo de la section profil représentant une personne">
            <h2>Votre compte</h2>
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "home") echo 'class="selected"'; ?> href="index.php?preferences=home">Consulter vos informations</a>
            <a <?php if($_GET['preferences'] == "edit-password") echo 'class="selected"'; ?> href="">Modifier votre mot de passe</a>
        </content>
    </article>
    <article>
        <header>
            <img src="layouts\assets\img\logo\white-utilisateurs.svg" alt="Logo de la section utilisateurs représentant un groupe de personne">
            <h2>Utilisateurs</h2>
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "liste-utilisateurs") echo 'class="selected"'; ?> href="index.php?preferences=liste-utilisateurs">Liste des utilisateurs</a>
            <a <?php if($_GET['preferences'] == "liste-nouveaux-utilisateurs") echo 'class="selected"'; ?> href="">Nouveaux utilisateurs</a>
            <a <?php if($_GET['preferences'] == "historique") echo 'class="selected"'; ?> href="">Historique de connexion</a>
        </content>
    </article>
    <article>
        <header>
            <img src="layouts\assets\img\logo\white-data.svg" alt="Logo de la section données représentant un nuage">
            <h2>Données</h2>
        </header>
        <content>
            <a <?php if($_GET['preferences'] == "liste-postes") echo 'class="selected"'; ?> href="">Postes</a>
            <a <?php if($_GET['preferences'] == "liste-services") echo 'class="selected"'; ?> href="">Services</a>
            <a <?php if($_GET['preferences'] == "liste-etablissements") echo 'class="selected"'; ?> href="">Etablissements</a>
            <a <?php if($_GET['preferences'] == "liste-poles") echo 'class="selected"'; ?> href="">Pôles</a>
            <a <?php if($_GET['preferences'] == "autres") echo 'class="selected"'; ?> href="">Autres</a>
        </content>
    </article>
</aside>