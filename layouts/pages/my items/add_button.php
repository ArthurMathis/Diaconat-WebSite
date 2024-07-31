<?php if($_SESSION['user_role'] != INVITE): ?>
    <a href="<?php if(isset($link)) echo $link; ?>" class="circle_button add_button">
        <img src="layouts\assets\img\logo\white-plus.svg" alt="Logo d'ajout d'un item', représenté par un symbole">
    </a>
<?php endif ?>