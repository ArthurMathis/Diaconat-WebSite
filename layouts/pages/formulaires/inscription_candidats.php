<form class="big-form" method="post" action="index.php?candidatures=inscription-candidat">
    <div class="form-container">
        <section>
            <h2>Coordonnées</h2>
            <input type="text" id="nom" name="nom" placeholder="Nom">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom">
            <input type="email" id="email" name="email" placeholder="Adresse email">
            <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone">
        </section>
        <section>
            <h2>Adresse</h2>
            <input type="text" id="adresse" name="adresse" placeholder="Adresse postale">
            <div class="double-items">
                <input type="text" id="ville" name="ville" placeholder="Commune">
                <input type="number" id="code-postal" name="code-postal" placeholder="Code postal">
            </div>
        </section>
        <section>
            <h2>Diplômes</h2>
            <input type="text" id="diplome-1" name="diplome-1" placeholder="Diplome 1">
            <input type="text" id="diplome-2" name="diplome-2" placeholder="Diplome 2">
            <input type="text" id="diplome-3" name="diplome-3" placeholder="Diplome 3">
        </section>
        <section>
            <h2>Aides au recrutement</h2>
            <select name="aide">
                <option value="">Aide</option>
                <?php foreach($aide as $c): ?>
                    <option value="<?= $c['Id_Aides_au_recrutement']; ?>">
                        <?= $c['Intitule_Aides_au_recrutement']; ?>
                    </option>
                <?php endforeach ?>    
            </select>
        </section>
        <section>
            <h2>Visite médicale</h2>
            <section class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="visite_medicale_true">Visite en règle</label>
                    <input type="radio" id="visite_medicale_true" name="visite_medicale" value="true"/>
                </div>
                <div class="checkbox-item">
                    <label for="visite_medicale_false">Visible obselète</label>
                    <input type="radio" id="visite_medicale_false" name="visite_medicale" value="false" checked/>
                </div>
            </section> 
        </section>
          
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div> 
</form>