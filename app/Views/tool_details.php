<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// History template
$page_session = \Config\Services::session(); // starting and storing the user session

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Usage details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('history/usage_history'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Usage details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <?php foreach ($usage_detail as $data) : ?>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?= $data->tool; ?></h3>
          <h3 class="card-title float-right"><a href="<?= base_url('history/usage_history'); ?>">View History</a></h3>
        </div>
        <div class="card-body">
           <span><?= $data->date; ?></span>
           <hr>
           <p><?= $data->prompt; ?></p>
           <hr>
           <pre><?= $data->result; ?></pre>
        </div>
        <!-- /.card-body -->
      </div>
      <?php endforeach; ?>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->