<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Home Page template

?>

<div class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url(); ?>" class="h1"><img src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" style="height: auto; width: 100%;" alt="custom chat gpt"><br><img src="<?= base_url('/public/assets/img/logo/cgpt_logo-back.png'); ?>" style="height: auto; width: 100%;" alt="custom chat gpt logo"></a>
    </div>
    <div class="card-body">
      <p class="text-center">A Micro SaaS based on Chat GPT API that you can customize</p>
      <!-- /.social-auth-links -->

      <p class="mb-2">
        <a href="<?= base_url('home/login'); ?>" class="btn btn-primary btn-block">Sign In</a>
      </p>
      <p class="mb-3">
      <a href="<?= base_url('home/register'); ?>" class="btn btn-dark btn-block">Sign Up</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
</div>