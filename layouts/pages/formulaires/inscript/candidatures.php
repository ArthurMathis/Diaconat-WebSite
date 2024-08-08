<form class="small-form" method="post" action="index.php?candidatures=inscription-candidature">
    <h3>Saisissez les informations de la candidature</h3>
    <section>
        <p>Emploi</p>
        <div class="autocomplete">
            <input type="text" id="poste" name="poste" placeholder="Poste" autocomplete="off">
            <article></article>
        </div>
        <div class="autocomplete">
            <input type="text" id="service" name="service" placeholder="Services" autocomplete="off">
            <article></article>
        </div>
    </section>
    <section>
        <p>Infos</p>
        <div class="autocomplete">
            <input type="text" id="type_de_contrat" name="type_de_contrat" placeholder="Type de contrat" autocomplete="off">
            <article></article>
        </div>
        <input type="Date" id="disponibilite" name="disponibilite" min="<?php echo Instants::currentInstants()->getDate(); ?>">
        <div class="autocomplete">
            <input type="text" id="source" name="source" placeholder="Sources" autocomplete="off">
            <article></article>
        </div>
    </section>
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>

<script>
    console.log('On lance la récupération des tableaux PHP.');

    // On récupère les données depuis PHP
    const postes = <?php echo json_encode(array_map(function($c) { return $c['Intitule_Postes']; }, $poste)); ?>;
    const services = <?php echo json_encode(array_map(function($c) {  return $c['Intitule_Services'];  }, $service)); ?>;
    const typeContrat = <?php echo json_encode(array_map(function($c) { return $c['Intitule_Types_de_contrats']; }, $typeContrat)); ?>;
    const source = <?php echo json_encode(array_map(function($c) { return $c['Intitule_Sources']; }, $source)); ?>;
    // On prépare les AutoCompletes
    new AutoComplete(document.getElementById('poste'), postes);
    new AutoComplete(document.getElementById('service'), services);
    new AutoComplete(document.getElementById('type_de_contrat'), typeContrat);
    new AutoComplete(document.getElementById('source'), source);
</script>