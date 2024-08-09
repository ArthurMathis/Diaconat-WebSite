<div>
    <header>
        <h2><?php echo strtoupper($items['utilisateur']['Nom']) . " " . forms_manip::nameFormat($items['utilisateur']['Prenom']); ?></h2>
        <p><?php echo forms_manip::nameFormat($items['utilisateur']['Role']);?></p>
    </header>
    <content>
        <div class="container">
            <p>Nom :</p>
            <p><?= strtoupper($items['utilisateur']['Nom']); ?></p>
        </div>
        <div class="container">
            <p>Prénom :</p>
            <p><?= forms_manip::nameFormat($items['utilisateur']['Prenom']); ?></p>
        </div>
        <div class="container">
            <p>Email :</p>
            <p><?= $items['utilisateur']['Email']; ?></p>
        </div>
    </content>
    <footer>
        <?php if($items['utilisateur']['Cle'] == $_SESSION['user_key']): ?>
            <a class="action_button reverse_color" href="index.php?preferences=edit-user&cle_utilisateur=<?= $items['utilisateur']['Cle']; ?>">Modifier</a>
        <?php elseif($items['utilisateur']['Role'] != "Propriétaire"): ?> 
            <div id="popup" class="sous-menu">
                <img class="circle_button" src="layouts\assets\img\logo\sous-menu.svg" alt="">
                <content>
                    <a href="index.php?preferences=edit-user&cle_utilisateur=<?= $items['utilisateur']['Cle']; ?>">Modifier</a>
                    <a href="index.php?preferences=get-reset-password&cle_utilisateur=<?= $items['utilisateur']['Cle']; ?>">Réinitialiser le mot de passe</a>
                </content>
                <script>
                    const popupButton = document.getElementById('popup').querySelector('img');
                    const popup = document.getElementById('popup').querySelector('content');

                    let visible = false;
                    popupButton.addEventListener('click', () => {
                        if(visible) 
                            popupButton.parentNode.classList.remove('visible');
                        else
                            popupButton.parentNode.classList.add('visible');

                        visible = !visible;    
                    });
                    popup.addEventListener('mouseleave', () => { 
                        popupButton.parentNode.classList.remove('visible'); 
                        visible = false;
                    });
                </script>
            </div>   
        <?php endif ?>
    </footer>
</div>