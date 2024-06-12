<form method="post" action="index.php?candidatures=recherche-candidat">
    <h2>Coordonnées</h2>
    <input type="text" id="nom" name="nom" placeholder="Nom">
    <input type="text" id="prenom" name="prenom" placeholder="Prénom">
    <input type="email" id="email" name="email" placeholder="Adresse email">
    <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone">
    <section class="buttons_actions">
        <button type="submit" class="submit_button" value="new_user">Rechercher</button>
    </section> 
    <p class="user-link">Nouveau candidat ? <a href="index.php?candidatures=saisie-nouveau-candidat">L'inscrire</a><p>
</form>