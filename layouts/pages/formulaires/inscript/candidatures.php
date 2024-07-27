<form class="small-form" method="post" action="index.php?candidatures=inscription-candidature">
    <h3>Saisissez les informations de la candidature</h3>
    <section>
        <p>Emploi</p>
        <!--<input type="text" id="poste" name="poste" placeholder="Poste">-->
        <div class="autocomplete">
            <input type="text" id="poste" name="poste" placeholder="Poste">
                <article></article>
            </div>
        <input type="text" id="service" name="service" placeholder="Services">
    </section>
    <section>
        <p>Infos</p>
        <input type="text" id="type_de_contrat" name="type_de_contrat" placeholder="Type de contrat">
        <input type="Date" id="disponibilite" name="disponibilite">
        <input type="text" id="source" name="source" placeholder="Sources">
    </section>
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>

<script>
    console.log('On lance la récupération du tableau de postes PHP.');

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

    // On récupère la liste des sources depuis PHP
    const source = <?php echo json_encode(array_map(function($c) {
        return $c['Intitule_Sources'];
    }, $source)); ?>;
    console.log(source);

    // On récupère la liste 
    console.log('Récupération des ressources terminées.');

    new AutoComplete(document.getElementById('poste'), postes);
</script>