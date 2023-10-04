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
            <h1>All History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('history/usage_history'); ?>">Home</a></li>
              <li class="breadcrumb-item active">All History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
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
      </div>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">AI tools usage list</h3>
          <h3 class="card-title float-right"><a href="<?= base_url('history/delete_usage'); ?>" onclick="return confirm('Do you want to Delete all data?')">Delete All</a></h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="jsdata" class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                          <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">User ID</th>
                            <th class="text-center">Tool Name</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <?php foreach ($allusage as $data) : ?>
                        <tbody>
                          <tr>
                            <td class="text-center"><?= $data->id; ?></td>
                            <td class="text-center"><?= $data->uid; ?></td>
                            <td class="text-center"><?= $data->tool; ?></td>
                            <td class="text-center"><?= $data->date; ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('history/usage_detail');?>/<?= $data->id; ?>" class="btn bg-primary"><i class="fas fa-eye small"></i> View Details</a>

                                <a onclick="return confirm('Do you want to Delete the history?')" href="<?= base_url('history/delete_history');?>/<?= $data->id; ?>" class="btn bg-danger"><i class="fas fa-trash small"></i> Delete History</a>
                            </td>
                          </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->