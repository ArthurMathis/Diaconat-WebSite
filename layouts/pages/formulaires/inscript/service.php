<form class="small-form" method="post" action="index.php?preferences=inscription-service">
    <h3>Saissez les informations du service</h3>
    <section>
        <p>Informations relatives à la fondation</p>
        <input type="text" id="service" name="service" placeholder="Service">
        <div class="autocomplete">
            <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement">
            <article></article>
        </div>
    </section>
    <button type="submit" class="submit_button" value="new_user">Valider</button>
</form>

<script>
    console.log('On lance la récupération des tableaux PHP.');  

    // On récupère les donnéesdepuis PHP
    const etablissements = <?php echo json_encode(array_map(function($c) { return $c['Intitule_Etablissements']; }, $etablissements)); ?>;
    // On prépare les AutoCompletes 
    new AutoComplete(document.getElementById('etablissement'), etablissements);

</script>