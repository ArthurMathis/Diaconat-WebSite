<div class="propositions_bulle">
    <header>
        <h2><?= $item['mission']['intitule']; ?></h2>
        <p><?= $item['mission']['service']; ?></p>
        <p><?= $item['mission']['etablissement']; ?></p>
    </header>
    <article>
        <h3><?= $item['type contrat']; ?></h3>
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
            <p><?= $item['date debut']; ?></p>
        </div>
        <div>
            <p>Fin du contrat</p>
            <p><?= $item['date fin']; ?></p>
        </div>
        <div>
            <p>Horaire</p>
            <p><?= $item['horaires']['heures']; ?> heures</p>
            <?php if($item['horaires']['nuit'] == 'true'): ?>
                <p>Emploi de nuit</p>
            <?php endif ?>    
            <?php if($item['horaires']['week-end'] == 'true'): ?>
                <p>Emploi de week-end</p>
            <?php endif ?>  
        </div>
    </content>
</div>