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

<div class="login-box">

  <!-- /.forgot-pass-logo -->
  <div class="card card-outline card-primary">

    <div class="card-header text-center">
      <a href="<?= base_url(); ?>" class="h1"><img src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" style="height: 70px; width: 70px;" alt="custom chat gpt"><br><b>Verify</b> User</a>
    </div>

    <div class="card-body">
      <p class="login-box-msg">Check account exist or not</p>

      <?= form_open('home/forgot_password'); ?>

        <div class="input-group mb-3">
          <?= csrf_field(); ?>
        </div>
        
        <span class="text-danger"><?= display_err($validation, 'email_id'); ?></span>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email_id" value="<?= set_value('email_id'); ?>" required>
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
            <button type="submit" class="btn btn-primary btn-block">Verify Account</button>
          </div>
          <!-- /.col -->
        </div>

      <?= form_close(); ?>
      <!-- /.other links -->

      <p class="text-center mb-1">
        <a class="btn btn-dark btn-block" href="<?= base_url('home/login') ?>" class="text-center">Back to Login</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
</div>