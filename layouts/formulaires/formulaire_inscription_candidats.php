<form method="post" action="index.php?candidatures=inscription-candidat">
    <h2>Coordonnées</h2>
    <input type="text" id="nom" name="nom" placeholder="Nom">
    <input type="text" id="prenom" name="prenom" placeholder="Prénom">
    <input type="email" id="email" name="email" placeholder="Adresse email">
    <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone">
    <h2>Adresse</h2>
    <input type="text" id="adresse" name="adresse" placeholder="Adresse postale">
    <div class="double-items">
        <input type="text" id="ville" name="ville" placeholder="Commune">
        <input type="number" id="code-postal" name="code-postal" placeholder="Code postal">
    </div>
    <h2>Aides au recrutement</h2>
    <input type="text" id="aides" name="aides" placeholder="Aides">
    <h2>Diplômes</h2>
    <input type="text" id="diplome-1" name="diplome-1" placeholder="Diplome">
    <input type="text" id="diplome-2" name="diplome-2" placeholder="Diplome">
    <input type="text" id="diplome-3" name="diplome-3" placeholder="Diplome">
    <section class="buttons_actions">
        <button type="submit" class="submit_button" value="new_user">Valider</button>
    </section> 
    <p class="user-link">Candidat déjà inscrit ? <a href="">Le rechercher</a><p>
</form>