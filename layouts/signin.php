<img src="layouts/assets\img\photo_log-in.jpg" alt="Illustration de l'hopithal">
<form method="post" ation="index.php?login=inscription">
    <img src="layouts/assets/img/ico_diaconat_mulhouse.webp">
    <h2>Saisissez vos infrmations pour vous inscrire</h2>
    <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
    <input type="text" id="email" name="email" placeholder="Adresse mail">
    <input type="password" id="motdepasse" name="motdepasse" placeholder="Mot de passe">
    <input type="password" id="confirmation" name="confirmation" placeholder="Confirmation du mot de passe">
    <section class="checkbox-liste">
        <div class="checkbox-item">
            <label for="remember1">Se souvenir de moi</label>
            <input type="checkbox" id="remember1" name="option1" value="option1">
        </div>
    </section>
    <section class="buttons_actions">
        <button type="submit" class="submit_button" value="new_user">Valider</button>
    </section>
    <p class="user-link">Vous avez déjà un compte <a href="index.php?login=get_connexion">Connectez-vous</a><p>
</form>