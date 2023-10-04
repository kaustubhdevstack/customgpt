<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// Dashboard Navigation Template
$page_session = \Config\Services::session(); // starting and storing the user session
?>

<nav class="main-header navbar navbar-expand navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user-circle"></i>
          <?= $teamdata->fname; ?> <?= $teamdata->lname; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Your Account</span>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('dashboard/profile'); ?>" class="dropdown-item">
          <i class="fas fa-user mr-2"></i>
            <span class="profile-link text-center">Visit Profile</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('dashboard/logout'); ?>" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i>
          <span class="profile-link text-center">Logout</span>
          </a>
        </div>
      </li>
  </ul>
</nav>
  <!-- /.navbar -->
