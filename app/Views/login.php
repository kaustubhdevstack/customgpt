<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Login Template
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
  
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">

    <div class="card-header text-center">
      <a href="<?= base_url(); ?>" class="h1"><img src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" style="height: 70px; width: 70px;" alt="custom chat gpt"><br><b>Login</b> User</a>
    </div>

    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?= form_open('home/login'); ?>

        <div class="input-group mb-3">
          <?= csrf_field(); ?>
        </div>

        <span class="text-danger"><?= display_err($validation, 'email_id'); ?></span>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email_id" value="<?= set_value('email_id'); ?>" required>
        </div>

        <span class="text-danger"><?= display_err($validation, 'passwd'); ?></span>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="passwd" required>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="icheck-primary mb-1 mt-1 float-left">
              <input type="checkbox" id="remember" required>
              <label for="remember">
                I am Human!
              </label>
            </div>
          </div>
          <div class="col-6">
              <div class="forgot-pass mb-1 mt-1 float-right">
                  <a class="text-dark" href="<?= base_url('home/forgot_password') ?>">Forgot Password?</a>
              </div>
          </div>
          <!-- /.col -->
          <div class="col-12 mb-3">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>

      <?= form_close(); ?>
      <!-- /.other links -->

      <p class="text-center mb-0">
        <a class="btn btn-dark btn-block" href="<?= base_url('home/register') ?>" class="text-center">Register Admin</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
</div>