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
                case 'acceptee':
                    echo '<p class="acceptee">Acceptée</p>';
                    break;

                case 'refusee':
                    echo '<p class="refusee">Refusée</p>';
                    break;

                case 'en attente':
                    echo '<p class="en-attente">En attente</p>';
                    break;

                case 'non traitee':
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
    <?php if($item['statut'] != 'acceptee' && $item['statut'] != 'refusee'): ?>
        <footer>
            <a class="action_button reject-button" href=""></a>
            <a class="action_button accept-button" href=""></a>
        </footer>
    <?php endif ?>    
</div>