<?php $flashdata = get_flashdata(); ?>

<?php if(!is_null($flashdata)): ?>

    <script>

    <?php if($flashdata['type'] === 'info'): ?>
        toastr.info('<?= $flashdata['message']; ?>');
    <?php endif; ?>

    <?php if($flashdata['type'] === 'warning'): ?>
        toastr.warning('<?= $flashdata['message']; ?>');
    <?php endif; ?>

    <?php if($flashdata['type'] === 'error'): ?>
        toastr.error('<?= $flashdata['message']; ?>');
    <?php endif; ?>

    <?php if($flashdata['type'] === 'success'): ?>
        toastr.success('<?= $flashdata['message']; ?>');
    <?php endif; ?>
    </script>



<?php endif; ?>
