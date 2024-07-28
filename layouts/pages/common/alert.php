<?php if(isset($infos['confirm'])): ?>
    <script>
        Swal.fire({
            title: "<?= $infos['title']; ?>",
            html: "<?= $infos['msg']; ?>",
            icon: "<?= $infos['icon']; ?>",
            backdrop: false,
            focusConfirm: false,
            showCancelButton: true,
            cancelButtonText: '<?php echo isset($infos['deleteButton']) ? $infos['deleteButton'] : 'Annuler'; ?>',
            confirmButtonText: '<?php echo isset($infos['confirmButton']) ? $infos['confirmButton'] : 'Confirmer'; ?>',
            customClass: {
                popup: 'notification',
                title: 'notification-title',
                content: 'notification-content',
                confirmButton: 'action_button reverse_color',
                cancelButton: 'action_button cancel_button',
                actions: 'custom-actions'
            }
        }).then((result) => {
            // SI l'utilisateur confirme
            if (result.isConfirmed)
                window.location.href = '<?= $infos['direction']; ?>';

            // Sinon
            else if (result.dismiss === Swal.DismissReason.cancel) 
            <?php if(isset($infos['back']) && !empty($infos['back']) && is_string($infos['back'])): ?>
                window.location.href = '<?= $infos['back']; ?>';
            <?php else: ?>    
                window.history.back();
            <?php endif; ?>    
        });
    </script>
<?php else: ?>
    <?php if(isset($infos['button'])): ?>
    <script>
        Swal.fire({
            title: "<?= $infos['title']; ?>",
            html: "<?= $infos['msg']; ?>",
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
                window.location.href = "<?= $infos['direction']; ?>"
            <?php else: ?>    
                window.history.back();
            <?php endif ?>    
        });
    </script>
    <?php else: ?>
    <script>
        Swal.fire({
            title: "<?= $infos['title']; ?>",
            html: "<?= $infos['msg']; ?>",
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
<?php endif; ?>

<style>
    .custom-actions {
        display: flex;
        justify-content: center;
        gap: 10px; 
        flex-direction: row-reverse; 
    }

    b {
        font-family: "Roboto Bold";
    }
</style>