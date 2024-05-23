<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaconat - Connexion</title>

    <link rel="stylesheet" href="stylesheet\styles.css">
    <link rel="stylesheet" href="stylesheet\connexion.css">
    <link rel="stylesheet" href="stylesheet\AnimateLignes.css">
</head>
<body>
    <?php include("components/connect_server.php") ?>

    <img src="assets\img\ico_diaconat_mulhouse.webp">

    <?php 
        // à compléter
    ?>

    <form method="post">
        <h1>Se connecter</h1>
        <div class="separator"></div>
        <section>
            <label for="identifiant">Identifiant :</label>
            <input type="text" id="identifiant" name="identifiant">
        </section>
        <section>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password">
        </section>
        <section class="buttons_actions">
            <a class="LignesHover" href="view/inscription.php">Nouvel utilisateur</a>
        <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </form>
</body>
</html>