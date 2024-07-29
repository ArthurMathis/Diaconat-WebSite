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
        <section id='diplome-section' class="imp-section">
            <p>Diplômes</p>
            <button class="form_button" type="button" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
        </section>
        <section id='aide-section' class="imp-section">
            <p>Aides au recrutement</p>
            <button class="form_button" type="button" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
        </section>
        <section id='visite-section' class="imp-section">
            <p>Date d'expiration de la visite médicale</p>
            <button class="form_button" type="button" style="margin-left: auto">
                <img src="layouts\assets\img\logo\plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
            </button>
        </section>
        <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
        </section>
    </div> 
</form>

<script>
    const diplome = new implementInput('diplome', 'diplome-section', 'autocomplete', <?= count($diplome); ?>, <?= json_encode($diplome); ?>);
    const aide = new implementInput('aide', 'aide-section', 'liste', <?= count($aide); ?>, <?= json_encode($aide); ?>);
    const visiteMedicale = new implementInput('visite_medicale', 'visite-section', 'date', 1, []);

    // Données de test
    const suggestions = [
        {
            text: 'mathis.a'
        },
        {
            text: 'husser.v'
        },
        {
            text: 'deroussin.e'
        },
        {
            text: 'mathis.l'
        }
    ];

    const nbCooptInput = 0;
    document.addEventListener('elementCreated', function(e) {
        if(e.detail.element.parentNode === document.getElementById('aide-section')) {
            const aideSection = document.getElementById('aide-section');
            const inputAide = aideSection.querySelectorAll('select');
            
            const obj = new cooptInput(inputAide[inputAide.length - 1], 'coopteur', 3, suggestions);
            obj.input.addEventListener('change', (e) => obj.react());
        }
    });
</script>