<?php if (!empty($param['errors']) && is_array($param['errors'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Vous devez corriger les erreurs suivantes :</strong>
        <ul>
            <?php foreach ($param['errors'] as $error): ?>
            <li><?php echo $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
