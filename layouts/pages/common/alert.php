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
        }
    <?php if(isset($infos['button'])): ?>,
            confirmButtonText: "<?= $infos['text button']; ?>"
        }).then((result) => {
            if (result.isConfirmed) 
            <?php if(isset($infos['direction'])): ?>
                window.location.href = <?= $infos['direction']; ?>
            <?php else: ?>    
                window.history.back();
            <?php endif ?>    
        });
    <?php else: ?>
        });
        // Redirection après 3 secondes
        setTimeout(() => {
            <?php if(isset($infos['direction'])): ?>
                window.location.href = <?= $infos['direction']; ?>
            <?php else: ?>    
                window.history.back();
            <?php endif ?>    
        }, 30000000);
    <?php endif; ?>
</script>