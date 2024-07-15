<aside>
    <header>
        <div>
            <h2><?= $item['candidat']['nom']; ?></h2>
            <?php if(empty($item['candidat']['notation'])) : ?>
                <p>Aucun notation renseignée</p>
            <?php else: ?>    
                <li class="notation">
                    <ul class="bille_notation <?php if(0 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile.svg"></ul>
                    <ul class="bille_notation <?php if(1 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile.svg"></ul>
                    <ul class="bille_notation <?php if(2 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile.svg"></ul>
                    <ul class="bille_notation <?php if(3 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile.svg"></ul>
                    <ul class="bille_notation <?php if(4 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile.svg"></ul>
                </li>
            <?php endif ?>  
        </div>
        <div>
            <h2><?= $item['candidat']['prenom']; ?></h2>
            <?php if($item['candidat']['a'] || $item['candidat']['b'] || $item['candidat']['c']): ?>
                <p>Alerte notation !</p>
            <?php endif ?>
        </div>
        <h3><?= $item['candidatures'][0]['type_de_contrat']; ?></h3>
        <p><?= forms_manip::nameFormat($item['candidatures'][0]['statut']); ?></p>  
    </header>
    <section>
        <div>
            <p>Diplômes</p>
            <div>
                <?php if(isset($item['candidat'][0]['diplomes']) && 0 < count($item['candidat'][0]['diplomes'])): ?>
                    <?php foreach($item['candidat'][0]['diplomes'] as $obj): ?>
                        <p><?= $obj['Intitule_Diplomes']; ?></p>
                    <?php endforeach ?>   
                <?php else : ?>
                    <p>Aucun diplôme saisie</p>     
                <?php endif ?>    
            </div>
        </div>
        <div>
            <p>Disponibilité</p>
            <p><?= $item['candidat']['disponibilite']; ?></p>
        </div>
        <div>
            <p>Service demandé</p>
            <?php if(empty($item['candidatures'][0]['service'])): ?>
                <p>Aucun service renseigné</p>
            <?php else: ?>
                <p><?= $item['candidatures'][0]['service']; ?></p>
            <?php endif ?>
        </div>
        <div>
            <p>Etablissement demandé</p>
            <?php if(empty($item['candidatures'][0]['etablissement'])): ?>
                <p>Aucun établissement renseigné</p>
            <?php else: ?>
                <p><?= $item['candidatures'][0]['etablissement']; ?></p>
            <?php endif ?>
        </div>
        <div>
            <p>Aide au recrutement</p>
            <?php if($item['aide'] == null): ?>
                <p>Aucune aide au recrutement</p>
            <?php else: ?>
                <p><?= $item['aide']['intitule']?></p>    
            <?php endif ?>    
        </div>
    </section>
    <section>
        <div>
            <p>Numéro de téléphone</p>
            <p><?= $item['candidat']['telephone']; ?></p>
        </div>
        <div>
            <p>Adresse email</p>
            <p><?= $item['candidat']['email']; ?></p>
        </div>
        <div>
            <p>Adresse</p>
            <div>
                <p><?= $item['candidat']['adresse']; ?></p>
                <p><?= $item['candidat']['ville']; ?></p>
                <p><?= $item['candidat']['code_postal']; ?></p>
            </div>
        </div>
    </section>
    <footer>
        <a class="circle_button reverse_color" href="mailto:<?= $item['candidat']['email']; ?>">
            <img src="layouts\assets\img\logo\white-paperplane.svg" alt="Logo d'envoi d'un courrier, représenté par un avion en papier">
        </a>
        <a class="circle_button reverse_color" href="index.php?candidats=edit-candidat&cle_candidat=<?= $item['candidat']['id']; ?>">
            <img src="layouts\assets\img\logo\white-edit.svg" alt="Logo de modification du candidat, représenté par un carnet et un stylo">
        </a>  
    </footer>
</aside>