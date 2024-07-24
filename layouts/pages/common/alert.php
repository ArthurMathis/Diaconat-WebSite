<?php if($direction): ?>
    <script>
        Swal.fire({
            title: "<?= $title; ?>",
            text: "<?= $msg; ?>",
            icon: "<?= $icon; ?>",
            confirmButtonText: "<?= $button; ?>",
        }).then((result) => {
            if (result.isConfirmed) 
                window.location.href = <?= $direction; ?>
        });
    </script>
<?php else: ?>
    <script>
        Swal.fire({
            title: "<?= $title; ?>",
            text: "<?= $msg; ?>",
            icon: "<?= $icon; ?>",
            confirmButtonText: "<?= $button; ?>",
        }).then((result) => {
            if (result.isConfirmed) 
                window.history.back();
        });
    </script>
<?php endif; ?>    