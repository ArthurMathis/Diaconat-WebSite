<div class="candidatures_bulle">
    <header>
        <h2><?= $item['poste']; ?></h2>
        <p><?= $item['service']; ?></p>
        <p><?= $item['etablissement']; ?></p>
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
</div>