<form class="small-form" method="post" action="index.php?preferences=inscription-etablissement">
    <h3>Saissez les informations de l'établissement</h3>
    <section>
        <p>Informations relatives à la fondation</p>
        <input type="text" id="intitule" name="intitule" placeholder="Intitulé">
        <select id="pole" name="pole">
            <?php foreach($poles as $c): ?>
                <option value="<?= $c['Intitulé']; ?>">
                    <?= $c['Intitulé']; ?>
                </option>
            <?php endforeach ?>    
        </select>
    </section>
    <section>
        <p>Localisation</p>
        <input type="text" id="adresse" name="adresse" placeholder="Adresse">
        <div class="double-items">
            <input type="text" id="ville" name="ville" placeholder="Commune">
            <input type="number" id="code-postal" name="code-postal" placeholder="Code postal">
        </div>
    </section>    
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>