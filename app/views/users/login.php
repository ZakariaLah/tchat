<?php require APPROOT . '/views/inc/header.php'; ?>
  <h2>Log in to your account</h2>
  <form action="<?php echo URLROOT; ?>/users/login" method="post">
    <div class="form-group">
      <label for="name">Username</label>
      <input type="text" name="name" class="form-control <?php echo (!empty($data['name_err']))? 'is-invalid' : ''; ?>" value="<?php echo $data['name'] ; ?>" >
      <span class="invalid-feedback"><?php echo $data['name_err'] ; ?></span>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="pwd" class="form-control <?php echo (!empty($data['password_err']))? 'is-invalid' : ''; ?>" value="<?php echo $data['password'] ; ?>" >
      <span class="invalid-feedback"><?php echo $data['password_err'] ; ?></span>
    </div>
    <div class="row">
      <div class="col">
        <button type="submit" class="btn btn-success">Login</button>
      </div>
      <div class="col">
        <a href="<?php echo URLROOT; ?>/users/register">no account? click to register</a>
      </div>
    </div>
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>