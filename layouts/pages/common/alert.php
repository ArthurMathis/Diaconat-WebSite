<?php if(isset($infos['button'])): ?>
<script>
    Swal.fire({
        title: "<?= $infos['title']; ?>",
        text: "<?= $infos['msg']; ?>",
        icon: "<?= $infos['icon']; ?>",
        backdrop: false,
        customClass: {
            popup: 'notification',
            title: 'notification-title',
            content: 'notification-content',
            confirmButton: 'action_button reverse_color'
        },
            confirmButtonText: "<?= $infos['text button']; ?>"
        }).then((result) => {
            if (result.isConfirmed) 
            <?php if(isset($infos['direction'])): ?>
                window.location.href = <?= $infos['direction']; ?>
            <?php else: ?>    
                window.history.back();
            <?php endif ?>    
        });
</script>
<?php else: ?>
<script>
    Swal.fire({
        title: "<?= $infos['title']; ?>",
        text: "<?= $infos['msg']; ?>",
        icon: "<?= $infos['icon']; ?>",
        backdrop: false,
        showConfirmButton: false,
        timer: 1500, 
        customClass: {
            popup: 'notification',
            title: 'notification-title',
            content: 'notification-content'
        }
    });

    // Redirection après 3 secondes
    setTimeout(() => {
        <?php if(isset($infos['direction'])): ?>
            window.location.href = "<?= $infos['direction']; ?>";
        <?php else: ?>    
            window.history.back();
        <?php endif ?>    
    }, 1500);
</script>
<?php endif; ?>
