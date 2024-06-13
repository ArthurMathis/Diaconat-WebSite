<nav class="navbarre">
    <?php if(0 < count($buttons)): ?>
        <?php foreach($buttons as $obj): ?>
            <p class="action_button"><?= $obj; ?></p>
        <?php endforeach ?>   
    <?php endif ?>    
</nav>