<form method="post" action="index.php?login=inscription">
    <h2>Informations personnelles</h2>
    <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
    <input type="text" id="nom" name="nom" placeholder="Nom">
    <input type="text" id="prenom" name="prenom" placeholder="Prénom">
    <h2>Informations de communication</h2>
    <input type="text" id="email" name="email" placeholder="Adresse mail">
    <h2>Mot de passe</h2>
    <input type="password" id="motdepasse" name="motdepasse" placeholder="Mot de passe">
    <input type="password" id="confirmation" name="confirmation" placeholder="Confirmation du mot de passe">
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>
<p class="user-link">Vous avez déjà un compte <a class="LignesHover" href="index.php?login=get_connexion">Connectez-vous</a><p>