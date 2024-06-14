<div class="contrats_bulle">
    <header>
        <h2><?= $item['mission']['intitule']; ?></h2>
        <p><?= $item['mission']['service']; ?></p>
        <p><?= $item['mission']['etablissement']; ?></p>
    </header>
    <article>
        <h3><?= $item['type contrat']; ?></h3>
        <?php 
            // On récupère la date actuelle
            require_once(CLASSE.DS.'Instants.php');
            $date = instants::currentInstants();
            
            if($date->getDate() < $item['date debut']): 
        ?>
            <p class="a_venir">A venir</p>
        <?php elseif($item['date fin'] < ($date->getDate() || $item['demission'])): ?>  
            <p class="termine">Terminé</p> 
        <?php else : ?> 
            <p class="en_cours">En cours</p> 
        <?php endif ?>    
    </article>
    <content>
        <div>
            <p>Recruté le</p>
            <p><?= $item['signature']; ?></p>
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