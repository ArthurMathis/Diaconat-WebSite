<div class="propositions_bulle">
    <header>
        <h2><?= $item['intitule']; ?></h2>
        <p><?= $item['service']; ?></p>
        <p><?= $item['etablissement']; ?></p>
    </header>
    <article>
        <h3><?= $item['type_de_contrat']; ?></h3>
        <?php if(!empty($item['signature'])): ?>
            <p class="acceptee">Acceptée</p>
        <?php elseif(!empty($item['statut'])) : ?>
            <p class="refusee">Refusée</p>
        <?php else : ?>
            <p class="en-attente">En attente</p>
        <?php endif ?>        
    </article>
    <content>
        <div>
            <p>Proposé le</p>
            <p><?= $item['proposition']; ?></p>
        </div>
        <div>
            <p>Début du contrat</p>
            <p><?= $item['date_debut']; ?></p>
        </div>
        <div>
            <p>Fin du contrat</p>
            <p><?= $item['date_fin']; ?></p>
        </div>
        <div>
            <p>Horaire</p>
            <p><?= $item['heures']; ?> heures</p>
            <?php if($item['nuit'] == 'true'): ?>
                <p>Emploi de nuit</p>
            <?php endif ?>    
            <?php if($item['week_end'] == 'true'): ?>
                <p>Emploi de week-end</p>
            <?php endif ?>  
        </div>
    </content>
</div>