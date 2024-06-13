<aside>
    <header>
        <h1><?= $item['candidat']['nom']; ?></h1>
        <h1><?= $item['candidat']['prenom']; ?></h1>
        <h2><?= $item['candidatures'][0]['type_de_contrat']; ?></h2>
        <div>
            <p><?= $item['candidatures'][0]['statut']; ?></p>
            <?php if(empty($note)) : ?>
                <p>Aucun notation renseignée</p>
            <?php else: ?>    
                <li class="notation">
                    <ul class="bille_notation <?php if(0 < $item['candidat']['notation']) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(1 < $item['candidat']['notation']) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(2 < $item['candidat']['notation']) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(3 < $item['candidat']['notation']) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(4 < $item['candidat']['notation']) echo "active"; ?>"></ul>
                </li>
            <?php endif ?>    
        </div>
    </header>
    <section>
        <div>
            <p>Numéro de téléphone:</p>
            <p><?= $item['candidat']['telephone']; ?></p>
        </div>
        <div>
            <p>Adresse email:</p>
            <p><?= $item['candidat']['email']; ?></p>
        </div>
        <div>
            <p>Adresse:</p>
            <div>
                <p><?= $item['candidat']['adresse']; ?></p>
                <p><?= $item['candidat']['ville']; ?></p>
                <p><?= $item['candidat']['code_postal']; ?></p>
            </div>
        </div>
    </section>
    <section>
        <div>
            <p>Diplômes:</p>
            <div>
                <?php if(0 < count($item['candidat']['diplomes'])): ?>
                    <?php foreach($item['candidat']['diplomes'] as $obj): ?>
                        <p><?= $obj; ?></p>
                    <?php endforeach ?>   
                <?php else : ?>
                    <p>Aucun diplôme saisie</p>     
                <?php endif ?>    
            </div>
        </div>
        <div>
            <p>Disponibilité:</p>
            <p><?= $item['candidat']['disponibilite']; ?></p>
        </div>
        <div>
            <p>Service demandé:</p>
            <p>
                <?php if(empty($item['candidatures'][0]['service'])): ?>
                    <p>Aucun service renseigné</p>
                <?php else: ?>
                    <?= $item['candidatures'][0]['service']; ?>
                <?php endif ?>        
            </p>
        </div>
        <div>
            <p>Etablissement demandé</p>
            <p>
                <?php if(empty($item['candidatures'][0]['etablissement'])): ?>
                    <p>Aucun établissement renseigné</p>
                <?php else: ?>
                    <?= $item['candidatures'][0]['etablissement']; ?>
                <?php endif ?>
            </p>
        </div>
    </section>
    <footer>
        <a class="action_button" href="">Exporter</a>
        <a class="action_button" href="">Editer</a>
    </footer>
</aside>