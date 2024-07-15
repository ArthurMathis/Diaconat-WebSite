<div class="candidatures_bulle">
    <header>
        <h2><?= $item['poste']; ?></h2>
        <?php if(empty($item['service'])): ?>
            <p>Aucun service spécifié</p>
        <?php else : ?>
            <p><?= $item['service']; ?></p>
        <?php endif ?>    
        <?php if(empty($item['etablissement'])): ?>
            <p>Aucun étalissement spécifié</p>
        <?php else : ?>
            <p><?= $item['etablissement']; ?></p>
        <?php endif ?>
    </header>
    <article>
        <h3><?= $item['type_de_contrat']; ?></h3>
        <?php 
            switch($item['statut']) {
                case 'Acceptée':
                    echo '<p class="acceptee">Acceptée</p>';
                    break;

                case 'Refusée':
                    echo '<p class="refusee">Refusée</p>';
                    break;

                case 'Non-traitée':
                    echo '<p class="non-traitee">Non traitée</p>';
                    break;
            }
        ?>
    </article>
    <content>
        <div>
            <p>Effectuée le</p>
            <p><?= $item['date']; ?></p>
        </div>
        <div>
            <p>Effectuée via</p>
            <p><?= $item['source']; ?></p>
        </div>
    </content>
    <?php if($item['statut'] == 'Non-traitée'): ?>
        <footer>
            <a class="circle_button" href="index.php?candidats=reject-candidatures&cle_candidature=<?= $item['cle']; ?>">
                <img src="layouts\assets\img\logo\white-close.svg" alt="Logo de refus de la candidature, représenté par une croix">
            </a>
            <?php if(empty($item['service'])): ?>
                <a class="circle_button" href="index.php?candidats=saisie-propositions-from-empty-candidature&cle_candidature=<?= $item['cle']; ?>">
                    <img src="layouts\assets\img\logo\white-valider.svg" alt="Logo de d'acceptation de la candidature, représenté par une coche">
                </a>
            <?php else : ?>
                <a class="circle_button" href="index.php?candidats=saisie-propositions-from-candidature&cle_candidature=<?= $item['cle']; ?>">
                    <img src="layouts\assets\img\logo\white-valider.svg" alt="Logo de d'acceptation de la candidature, représenté par une coche">
                </a>  
            <?php endif; ?>     
        </footer>
    <?php endif ?>    
</div>