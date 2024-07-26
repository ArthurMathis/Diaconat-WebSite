<form class="big-form" method="post" action="index.php?candidatures=inscription-candidat">
    <div class="form-container">
        <h3>Saisissez les informations du candidat</h3>
        <section>
            <p>Coordonnées</p>
            <input type="text" id="nom" name="nom" placeholder="Nom">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom">
            <input type="email" id="email" name="email" placeholder="Adresse email">
            <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone">
        </section>
        <section>
            <p>Adresse</p>
            <input type="text" id="adresse" name="adresse" placeholder="Adresse postale">
            <div class="double-items">
                <input type="text" id="ville" name="ville" placeholder="Commune">
                <input type="number" id="code-postal" name="code-postal" placeholder="Code postal">
            </div>
        </section>
        <section class="imp-section">
            <p>Diplômes</p>
            <!--<input type="text" id="diplome-1" name="diplomes[]" placeholder="Diplome">-->
            <button class="form_button" type="button" onClick="" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
        </section>
        <section class="imp-section">
            <p>Aides au recrutement</p>
            <!--<select name="aide">
                <option value="">Aide</option>
                <?php foreach($aide as $c): ?>
                    <option value="<?= $c['Id_Aides_au_recrutement']; ?>">
                        <?= $c['Intitule_Aides_au_recrutement']; ?>
                    </option>
                <?php endforeach ?>    
            </select>-->
            <button class="form_button" type="button" onClick="" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
        </section>
        <section>
            <p>Date d'expiration de la visite médicale</p>
            <input type="Date" id="visite medicale" name="visite medicale">
            <!--<div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="visite_medicale_true">Visite en règle</label>
                    <input type="radio" id="visite_medicale_true" name="visite_medicale" value="true"/>
                </div>
                <div class="checkbox-item">
                    <label for="visite_medicale_false">Visible obselète</label>
                    <input type="radio" id="visite_medicale_false" name="visite_medicale" value="false" checked/>
                </div>
            </div>-->
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div> 
</form>