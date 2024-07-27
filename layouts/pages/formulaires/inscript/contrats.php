<form class="big-form" method="post" action="index.php?candidats=inscript-contrats&cle_candidat=<?= $cle_candidat; ?>">
    <div class="form-container">
        <h3>Saisissez les informations du contrat</h3>
        <section>
            <p>Informations du poste</p>
            <div class="autocomplete">
                <input type="text" id="poste" name="poste" placeholder="Poste" autocomplete="off">
                <article></article>
            </div>
            <div class="autocomplete">
                <input type="text" id="service" name="service" placeholder="Services" autocomplete="off">
                <article></article>
            </div>
            <div class="autocomplete">
                <input type="text" id="type_contrat" name="type_contrat" placeholder="Type de contrats" autocomplete="off">
                <article></article>
            </div>
        </section>
        <section class="double-items">
            <div class="input-container">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut">
            </div>
            <div class="input-container">
                <label for="date_fin">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin">
            </div>  
        </section>
        <section>
            <p>Horaires et rémunérations</p>
            <input type="number" id="salaire_mensuel" name="salaire_mensuel" placeholder="salaire mensuel">
            <input type="number" id="taux_horaire_hebdomadaire" name="taux_horaire_hebdomadaire" placeholder="taux horaire hebdomadaire">
            <div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="travail_nuit">Travail de nuit</label>
                    <input type="checkbox" id="travail_nuit" name="travail_nuit">
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="travail_wk" name="travail_wk"/>
                    <label for="travail_wk">Travail le week-end</label>
                </div>
            </div>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div>
</form>


<script>
    console.log('On lance la récupération des tableaux PHP.');

    // On récupère la liste des postes depuis PHP
    const postes = <?php echo json_encode(array_map(function($c) {
        return $c['Intitule_Postes'];
    }, $poste)); ?>;
    console.log(postes);

    // On récupère la liste des services depuis PHP
    const services = <?php echo json_encode(array_map(function($c) { 
        return $c['Intitule_Services']; 
    }, $service)); ?>;
    console.log(services);

    // On récupère la liste des types de contrat depuis PHP
    const typeContrat = <?php echo json_encode(array_map(function($c) {
        return $c['Intitule_Types_de_contrats'];
    }, $typeContrat)); ?>;
    console.log(typeContrat);

    // On récupère la liste 
    console.log('Récupération des ressources terminées.');

    console.log('Mise en place des AutoComplet');
    new AutoComplete(document.getElementById('poste'), postes);
    new AutoComplete(document.getElementById('service'), services);
    new AutoComplete(document.getElementById('type_contrat'), typeContrat);
</script>