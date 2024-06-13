<aside>
    <header>
        <h1><?= $nom; ?></h1>
        <h1><?= $prenom; ?></h1>
        <h2><?= $type_contrat; ?></h2>
        <div>
            <p><?= $statut; ?></p>
            <?php if(empty($note)) : ?>
                <p>Aucun notation renseignée</p>
            <?php else: ?>    
                <li class="notation">
                    <ul class="bille_notation <?php if(0 < $note) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(1 < $note) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(2 < $note) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(3 < $note) echo "active"; ?>"></ul>
                    <ul class="bille_notation <?php if(4 < $note) echo "active"; ?>"></ul>
                </li>
            <?php endif ?>    
        </div>
    </header>
    <section>
        <div>
            <p>Numéro de téléphone:</p>
            <p><?= $telephone; ?></p>
        </div>
        <div>
            <p>Adresse email:</p>
            <p><?= $email; ?></p>
        </div>
        <div>
            <p>Adresse:</p>
            <div>
                <p><?= $adresse; ?></p>
                <p><?= $ville; ?></p>
                <p><?= $code_postal; ?></p>
            </div>
        </div>
    </section>
    <section>
        <div>
            <p>Diplômes:</p>
            <div>
                <?php if(0 < count($diplomes)): ?>
                    <?php foreach($diplomes as $obj): ?>
                        <p><?= $obj; ?></p>
                    <?php endforeach ?>   
                <?php else : ?>
                    <p>Aucun diplôme saisie</p>     
                <?php endif ?>    
            </div>
        </div>
        <div>
            <p>Disponibilité:</p>
            <p><?= $disponibilte; ?></p>
        </div>
        <div>
            <p>Service demandé:</p>
            <p>
                <?php if(empty($serive)): ?>
                    <p>Aucun service renseigné</p>
                <?php else: ?>
                    <?= $service; ?>
                <?php endif ?>        
            </p>
        </div>
        <div>
            <p>Etablissement demandé</p>
            <p>
                <?php if(empty($etablissement)): ?>
                    <p>Aucun établissement renseigné</p>
                <?php else: ?>
                    <?= $etablisseement; ?>
                <?php endif ?>
            </p>
        </div>
    </section>
    <footer>

    </footer>
</aside>