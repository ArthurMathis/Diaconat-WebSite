<form class="big-form" method="post" action="index.php?candidats=inscript-propositions&cle_candidat=<?= $cle_candidat; ?>">
    <div class="form-container">
    <h3>Saissisez les informations de la proposition</h3>
        <section>
                <p>Service et établissement</p>
                <div class="autocomplete">
                    <input type="text" id="poste" name="poste" placeholder="Poste" autocomplete="off">
                    <article></article>
                </div>
                <div class="autocomplete">
                    <input type="text" id="service" name="service" placeholder="Services" autocomplete="off">
                    <article></article>
                </div>
                <div class="autocomplete">
                    <input type="text" id="type_contrat" name="type_contrat" placeholder="Type de contrat" autocomplete="off">
                    <article></article>
                </div>
            </section>
        <section class="double-items">
            <div class="input-container">
                <label for="date debut">Date de début</label>
                <input type="date" name="date debut" id="date debut">
            </div>
            <div class="input-container">
                <label for="date fin">Date de fin</label>
                <input type="date" name="date fin" id="date fin">
            </div>
        </section>
        <section>
            <p>Horaires et rémunérations</p>
            <input id="salaire_mensuel" name="salaire_mensuel" type="number" placeholder="Salaire mensuel">
            <input id="taux_horaire_hebdomadaire" name="taux_horaire_hebdomadaire" type="number" placeholder="taux horaire hebdomadaire">
            <div class="checkbox-liste">
                <div class="checkbox-item">
                    <label for="travail nuit">Travail de nuit</label>
                    <input type="checkbox" id="travail nuit" name="travail nuit">
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="travail wk" name="travail wk"/>
                    <label for="travail wk">Travail le week-end</label>
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

    // On ajuste le nombre de formulaire de date
    const inputTypeContrat = document.getElementById('type_contrat');
    const inputDateFin = document.getElementById('date fin').parentElement;
    console.log(inputDateFin);

    // Fonction pour vérifier le type de contrat et ajuster l'affichage de la date de fin
    const checkContratType = () => {
        if (inputTypeContrat.value.trim().toUpperCase() === 'CDI') {
            inputDateFin.style.display = 'none';
        } else {
            inputDateFin.style.display = 'block';
        }
    };

    // Écouteurs d'événements sur l'input type_contrat pour détecter les changements de valeur
    inputTypeContrat.addEventListener('input', checkContratType);
    // Écouteur d'événement pour capturer la sélection d'une option d'autocomplétion
    inputTypeContrat.addEventListener('AutoCompleteSelect', checkContratType);
</script>