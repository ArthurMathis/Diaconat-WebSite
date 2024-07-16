<form class="big-form" method="post" action="index.php?preferences=inscription-utilisateur">
    <div class="form-container">
        <section>
            <h2>Informations personnelles</h2>
            <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
            <input type="text" id="nom" name="nom" placeholder="Nom">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom">
            <input type="text" id="email" name="email" placeholder="Adresse mail">
        </section>
        <section>
            <h2>Statut</h2>
            <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement">
            <select name="role">
                <?php foreach($role as $r): ?>
                    <option value="<?= $r['id']; ?>">
                        <?= $r['role']; ?>
                    </option>
                <?php endforeach ?>    
            </select>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Valider</button>
        </section>
    </div>
</form>