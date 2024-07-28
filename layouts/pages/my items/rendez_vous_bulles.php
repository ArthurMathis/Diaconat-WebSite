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
        <a class="circle_button" href="index.php?candidats=delete-rendez-vous&cle_candidat=<?= $item['cle_candidat']; ?>&cle_utilisateur=<?= $item['cle_utilisateur']; ?>&cle_instant=<?= $item['cle_instant']; ?>">
            <img src="layouts\assets\img\logo\white-trash.svg" alt="Logo de suppression du rendez-vous, représenté par une poubelle">
        </a>
        <a class="circle_button" href="index.php?candidats=edit-rendez-vous&cle_candidat=<?= $item['cle_candidat']; ?>&cle_utilisateur=<?= $item['cle_utilisateur']; ?>&cle_instant=<?= $item['cle_instant']; ?>">
            <img src="layouts\assets\img\logo\white-edit.svg" alt="Logo de modification du rendez-vous, représenté par un carnet et un stylo">
        </a>
    </footer>
</div>