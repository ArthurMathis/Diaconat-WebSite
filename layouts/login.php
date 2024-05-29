<img src="layouts/assets\img\photo_log-in.jpg" alt="Illustration de l'hopithal">
<form method="post" action="index.php?login=connexion">
    <img src="layouts/assets/img/ico_diaconat_mulhouse.webp">
    <h2>Entrez votre identifiant et mot de passe pour accéder au site web</h2>
    <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
    <input type="password" id="motdepasse" name="motdepasse" placeholder="Mot de passe">
    <section class="checkbox-liste">
        <div class="checkbox-item">
            <label for="remember1">Se souvenir de moi</label>
            <input type="checkbox" id="remember1" name="option1" value="option1">
        </div>
        <a class="LignesHover" href="">Mot de passe oublié</a>
    </section>
    <section class="buttons_actions">
        <button type="submit" class="submit_button" value="new_user">Se connecter</button>
    </section>
    <p class="user-link">Vous n'avez pas de compte <a href="inscription.php">Inscrivez-vous</a><p>
</form>