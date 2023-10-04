<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Forgot Password Template
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<div class="hold-transition login-page">

<!-- /.Errors -->
<div class="row">
    <div class="col-lg-12">
      <div class="contact__form__title">
        <?php if($page_session->getTempdata('success', 3)) : ?>
          <div class="alert alert-success">
        <?= $page_session->getTempdata('success', 3); ?>
          </div>
        <?php endif; ?>

        <?php if($page_session->getTempdata('error', 3)) : ?>
            <div class="alert alert-danger">
          <?= $page_session->getTempdata('error', 3); ?>
            </div>
        <?php endif; ?>
      </div>
  </div>
</div>
<?php if(isset($error)) : ?>
    <div class="alert alert-danger text-center"><?= $error; ?></div>
<?php else: ?>
<div class="login-box">

  <!-- /.forgot-pass-logo -->
  <div class="card card-outline card-primary">

    <div class="card-header text-center">
      <a href="<?= base_url(); ?>" class="h1"><img src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" style="height: 70px; width: 70px;" alt="custom chat gpt"><br><b>Reset</b> Password</a>
    </div>

    <div class="card-body">
      <p class="login-box-msg">Enter new account password</p>

      <?= form_open('home/reset_password/' . $token); ?>

        <div class="input-group mb-3">
          <?= csrf_field(); ?>
        </div>

        <span class="text-danger"><?= display_err($validation, 'passwd'); ?></span>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="passwd" required>
        </div>

        <span class="text-danger"><?= display_err($validation, 'cpassword'); ?></span>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm Password" name="cpassword" required>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="icheck-primary icheck-primary mb-1 mt-1">
              <input type="checkbox" id="remember" required>
              <label for="remember">
                I am Human!
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-12 mb-3">
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
          </div>
          <!-- /.col -->
        </div>

      <?= form_close(); ?>
    
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  <?php endif; ?>
</div>
<!-- /.login-box -->