<div class="contrats_bulle">
    <header>
        <h2><?= $item['poste']; ?></h2>
        <p><?= $item['service']; ?></p>
        <p><?= $item['etablissement']; ?></p>
    </header>
    <article>
        <h3><?= $item['type_de_contrat']; ?></h3>
        <?php 
            // On récupère la date actuelle
            require_once(CLASSE.DS.'Instants.php');
            $date = instants::currentInstants();
            
            if($date->getDate() < $item['date_debut']): 
        ?>
            <p class="a_venir">A venir</p>
        <?php elseif($item['date_fin'] < ($date->getDate() || $item['demission'])): ?>  
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