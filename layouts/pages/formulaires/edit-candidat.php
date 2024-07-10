<form class="big-form" method="post" action="index.php?candidats=update-candidat&cle_candidat=<?= $item['candidat']['id']?>">
    <div class="form-container">
        <section>
            <h2>Coordonnées</h2>
            <input type="text" id="nom" name="nom" placeholder="Nom" value="<?= $item['candidat']['nom']?>">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?= $item['candidat']['prenom']?>">
            <input type="email" id="email" name="email" placeholder="Adresse email" value="<?= $item['candidat']['email']?>">
            <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone" value="<?= $item['candidat']['telephone']?>">
        </section>
        <section>
            <h2>Adresse</h2>
            <input type="text" id="adresse" name="adresse" placeholder="Adresse postale" value="<?= $item['candidat']['adresse']?>">
            <div class="double-items">
                <input type="text" id="ville" name="ville" placeholder="Commune" value="<?= $item['candidat']['ville']?>">
                <input type="number" id="code-postal" name="code-postal" placeholder="Code postal" value="<?= $item['candidat']['code_postal']?>">
            </div>
        </section>
        <section>
            <h2>Diplômes</h2>
            <input type="text" id="diplome-1" name="diplome-1" placeholder="Diplome 1" value="<?php if(isset($item['candidat'][0]['diplomes'][0])) echo $item['candidat'][0]['diplomes'][0]["Intitule_Diplomes"]; ?>">
            <input type="text" id="diplome-2" name="diplome-2" placeholder="Diplome 2" value="<?php if(isset($item['candidat'][0]['diplomes'][1])) echo $item['candidat'][0]['diplomes'][1]["Intitule_Diplomes"]; ?>">
            <input type="text" id="diplome-3" name="diplome-3" placeholder="Diplome 3" value="<?php if(isset($item['candidat'][0]['diplomes'][2])) echo $item['candidat'][0]['diplomes'][2]["Intitule_Diplomes"]; ?>">
        </section>
        <section>
            <h2>Aides au recrutement</h2>
            <select name="aide">
                <option value="">Aide</option>
                <?php foreach($item['aide'] as $c): ?>
                    <option value="<?= $c['id']; ?>">
                        <?= $c['intitule']; ?>
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
            <button type="submit" class="submit_button" value="new_user">Mettre à jour</button>
        </section>
    </div> 
</form>