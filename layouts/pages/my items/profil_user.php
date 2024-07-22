<div>
    <header>
        <h2><?php echo strtoupper($items['utilisateur']['Nom']) . " " . forms_manip::nameFormat($items['utilisateur']['Prénom']); ?></h2>
        <p><?php echo forms_manip::nameFormat($items['utilisateur']['Role']);?></p>
    </header>
    <content>
        <div class="container">
            <p>Nom :</p>
            <p><?= strtoupper($items['utilisateur']['Nom']); ?></p>
        </div>
        <div class="container">
            <p>Prénom :</p>
            <p><?= forms_manip::nameFormat($items['utilisateur']['Prénom']); ?></p>
        </div>
        <div class="container">
            <p>Email :</p>
            <p><?= $items['utilisateur']['Email']; ?></p>
        </div>
    </content>
    <footer>
        <a class="action_button reverse_color" href="">Modifier</a>
    </footer>
</div>