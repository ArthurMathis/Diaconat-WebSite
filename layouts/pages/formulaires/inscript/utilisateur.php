<form class="big-form" method="post" action="index.php?preferences=get-inscription-utilisateur">
    <div class="form-container">
        <h3>Saissiez les informations du nouvel utilisateurs</h3>
        <section>
            <p>Informations personnelles</p>
            <input type="text" id="identifiant" name="identifiant" placeholder="Identifiant">
            <input type="text" id="nom" name="nom" placeholder="Nom">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom">
            <input type="text" id="email" name="email" placeholder="Adresse mail">
        </section>
        <section>
            <p>Statut</p>
            <div class="autocomplete">
                <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement" autocomplete="off">
                <article></article>
            </div>
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

<script>
    // On récupère les données depuis PHP
    const etablissements = <?php echo json_encode(array_map(function($c) { return $c['Intitule_Etablissements']; }, $etablissements)); ?>;
    // On prépare les AutoCompletes
    new AutoComplete(document.getElementById('etablissement'), etablissements);
</script>