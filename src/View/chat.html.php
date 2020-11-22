<h2>Bonjour <?php echo htmlentities($param['username']) ?></h2>

<?php foreach ($param['messages'] as $message): ?>
<div class="row">
    <div class="col col-md-12">
        <?php echo htmlentities($message['name']) ?> à <?php echo $message['creation_date'] ?>
    </div>
    <div class="col col-md-12">
        <?php echo htmlentities($message['message_text']) ?>
    </div>
    <hr />
</div>
<?php endforeach; ?>

<form method="post" action="/post">
    <div class="form-group">
        <label for="message">Votre réponse</label>
        <textarea id="message" name="message" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<br />
Connectés en ce moment :<br />
<?php $limit = count($param['connectedUsers']); ?>
<?php for($i = 0;$i < $limit;$i++): ?>
    <strong><?php echo htmlentities($param['connectedUsers'][$i]['name']) ?></strong>
    <?php if (($i+1) < $limit) { echo ' - '; } ?>
<?php endfor; ?>