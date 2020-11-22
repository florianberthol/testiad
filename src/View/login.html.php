<form method="post" action="/login">
    <div class="form-group">
        <label for="username">Login</label>
        <input type="text" required value="<?php echo $param['request']->getPost('username') ?>" class="form-control" name="username" id="username" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" required class="form-control" name="password" id="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>