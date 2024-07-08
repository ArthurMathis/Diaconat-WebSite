<div class="rendez_vous_bulle">
    <header>
        <h2><?php echo forms_manip::majusculeFormat($item['nom']) . ' ' . $item['prenom']; ?></h2>
        <p><?= $item['etablissement'] ?></p>
    </header>
    <content>
        <div>
            <p>Prévu le</p>
            <p><?= $item['date']; ?></p>
        </div>
        <div>
            <p>Prévu à</p>
            <p><?= $item['heure']; ?></p>
        </div>
    </content>
    <content>
        <div>
            <p>Compte rendu</p>
        </div>
        <?php if(empty($item['description'])): ?>
            <p style="color: var(--grey)">Aucun compte rendu saisi pour le moment.</p>
        <?php else: ?>
            <p><?= $item['description']; ?></p>    
        <?php endif?>    
    </content>
    <footer>
        <a class="action_button reverse_color" href="">Supprimer</a>
        <a class="action_button reverse_color" href="">Editer</a>
    </footer>
</div>