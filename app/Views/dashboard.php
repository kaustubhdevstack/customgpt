<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Dashboard Template
$page_session = \Config\Services::session(); // starting and storing the user session

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hello, <?= $teamdata->fname; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <!-- Box Comment -->
              <div class="card card-widget">
                <div class="card-header">
                  <div class="user-block">
                    <img class="img-circle" src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" alt="Custom Chat GPT Logo">
                    <span class="username">What is Custom GPT?</span>
                    <span class="description">Must Read</span>
                  </div>
                  <!-- /.user-block -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <p>Custom GPT is a micro SaaS powered by OpenAI API that offers customized AI prompts for developers, programmers, digital marketers, and content writers. This platform is designed to eliminate the need for brainstorming use cases for Chat GPT, meaning users don't have to spend time thinking about what to write in order to get solutions.
                  </p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          <!-- /.col -->
          <div class="col-md-12">
              <!-- Box Comment -->
              <div class="card card-widget">
                <div class="card-header">
                  <div class="user-block">
                    <img class="img-circle" src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" alt="Custom Chat GPT Logo">
                    <span class="username">What you can do & What you cannot!</span>
                    <span class="description">Must Read</span>
                  </div>
                  <!-- /.user-block -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <!-- post text -->
                  <p>Please read the usage terms and conditions here to see what you can modify and what you cannot modify: <a href="https://digiforge.in/terms-and-conditions/">Right to Modify, Reuse, Resell and Share</a> and <a href="https://digiforge.in/acceptable-use-policy/">Acceptable usage rights.</a></p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          <!-- /.col -->
            <div class="col-md-6">
              <!-- Box Comment -->
              <div class="card card-widget">
                <div class="card-header">
                  <div class="user-block">
                    <img class="img-circle" src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" alt="Custom Chat GPT Logo">
                    <span class="username">You can Modify the Source code!</span>
                    <span class="description">Must Read</span>
                  </div>
                  <!-- /.user-block -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <!-- post text -->
                  <p>At <a href="https://digiforge.in">DigiForge</a>, we firmly believe that the future lies in Low Code or No Code solutions. To that end, we provide developers, startups, and companies/organizations with a range of Micro SaaS Solutions that come with their source code. This allows them to purchase and modify the solutions as per their requirements.</p>
                  <p>PS. Why not try modifying this SaaS to boost your own productivity?</p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          <!-- /.col -->
          <div class="col-md-6">
              <!-- Box Comment -->
              <div class="card card-widget">
                <div class="card-header">
                  <div class="user-block">
                    <img class="img-circle" src="<?= base_url('/public/assets/img/logo/customgpt.png'); ?>" alt="Custom Chat GPT Logo">
                    <span class="username">Resources Used</span>
                    <span class="description">Must Read</span>
                  </div>
                  <!-- /.user-block -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <!-- post text -->
                  <p>Here are the resources we used to create this Micro SaaS:</p>
                  <p>
                    <ul>
                        <li class="text-dark">Framework - CodeIgniter 4.35</li>
                        <li class="text-dark">Admin LTE 3 - HTML Template</li>
                        <li class="text-dark">API - Open AI (Creator of Chat GPT)</li>
                    </ul>
                  </p>

                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          <!-- /.col -->
          </div>
            <!-- /.row -->
          </div>
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
