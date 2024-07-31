<form class="big-form" method="post" action="index.php?candidats=update-candidat&cle_candidat=<?= $item['candidat']['id']?>">
    <div class="form-container">
        <h3>Saisissez les informations du candidat</h3>
        <section>
            <p>Informations personnelles</p>
            <input type="text" id="nom" name="nom" placeholder="Nom" value="<?= $item['candidat']['nom']?>">
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?= $item['candidat']['prenom']?>">
            <input type="email" id="email" name="email" placeholder="Adresse email" value="<?= $item['candidat']['email']?>">
            <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone" value="<?= $item['candidat']['telephone']?>">
        </section>
        <section>
            <p>Informations habitation</p>
            <input type="text" id="adresse" name="adresse" placeholder="Adresse postale" value="<?= $item['candidat']['adresse']?>">
            <div class="double-items">
                <input type="text" id="ville" name="ville" placeholder="Commune" value="<?= $item['candidat']['ville']?>">
                <input type="number" id="code-postal" name="code-postal" placeholder="Code postal" value="<?= $item['candidat']['code_postal']?>">
            </div>
        </section>
        <section id='diplome-section'>
            <p>Diplômes</p>
            <button class="form_button" type="button" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
            <?php if(isset($item['candidat'][0]['diplomes'])) foreach($item['candidat'][0]['diplomes'] as $index => $d): ?>
                <input type="text" id="<?php echo 'diplome-'.$index+1; ?>" name="diplome[]" value="<?= $d["Intitule_Diplomes"]; ?>">
            <?php endforeach ?>   
        </section>      
        <section id='aide-section'>
            <p>Aides au recrutement</p>
            <button class="form_button" type="button" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
            <?php if(isset($item['candidat'][1]['aides'])) foreach($item['candidat'][1]['aides'] as $a): ?>
                <select name="aide">
                    <?php foreach($item['aide'] as $c): ?>
                        <option value="<?= $c['id']; ?>" <?php if($a == $c['text']) { $coopt = true; echo 'selected'; }?>>
                            <?= $c['text']; ?>
                        </option>
                    <?php endforeach ?>    
                </select> 
            <?php endforeach ?>
        </section>
        <section id='visite-section'>
            <p>Informations de la visite médicale</p>
            <?php if(isset($item['candidat']['VisiteMedicale_Candidats'])): ?>
                <input type="date" id="visite_medicale" name="visite_medicale[]" value="<?= $item['candidat']['VisiteMedicale_Candidats']; ?>">
            <?php else: ?>
                <button class="form_button" type="button" style="margin-left: auto">
                    <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
                </button>
            <?php endif ?>    
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Mettre à jour</button>
        </section>
    </div> 
</form>

<script>
    const diplome = new implementInput('diplome', 'diplome-section', 'autocomplete', <?= count($item['diplome']); ?>, <?= json_encode($item['diplome']); ?>);
    const aide = new implementInput('aide', 'aide-section', 'liste', <?= count($item['aide']); ?>, <?= json_encode($item['aide']); ?>);
    const visiteMedicale = new implementInput('visite_medicale', 'visite-section', 'date', 1, []);
</script>