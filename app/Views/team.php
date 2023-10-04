<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Team List or User List Template
$page_session = \Config\Services::session(); // starting and storing the user session

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Team Members</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard/team'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Team List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?= $active; ?></h3>

                <p>Active users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $inactive; ?></h3>

                <p>Inactive users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $blocked; ?></h3>

                <p>Blocked users</p>
              </div>
              <div class="icon">
              <i class="ion ion-person"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= $archived; ?></h3>

                <p>Archived users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

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
          <h3 class="card-title">The Admin</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                          <tr>
                            <th class="text-center">User ID</th>
                            <th class="text-center">User Name</th>
                            <th class="text-center">Email ID</th>
                            <th class="text-center">Account Status</th>
                            <th class="text-center">Date of Joining</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <?php foreach ($admindetails as $data) : ?>
                        <tbody>
                          <tr>
                            <td class="text-center"><?= $data->uid; ?></td>
                            <td class="text-center"><?= $data->fname; ?> <?= $data->lname; ?></td>
                            <td class="text-center"><?= $data->email_id; ?></td>
                            <td class="text-center"><?= $data->ac_status; ?></td>
                            <td class="text-center"><?= $data->date; ?></td>
                            <td class="text-center">
                              <a href="<?= base_url('dashboard/profile'); ?>" class="btn bg-primary"><i class="fas fa-eye small"></i> Visit Profile</a>
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

    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">List of users</h3>
          <h3 class="card-title float-right"><a href="<?= base_url('dashboard/add_user'); ?>">Add Team</a> | <a href="<?= base_url('dashboard/team_archive'); ?>">Team Archive</a></h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="jsdata" class="table table-bordered table-striped" style="width: 100%;">
                    <thead>
                          <tr>
                            <th class="text-center">User ID</th>
                            <th class="text-center">User Name</th>
                            <th class="text-center">Email ID</th>
                            <th class="text-center">Account Status</th>
                            <th class="text-center">Date of Joining</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <?php foreach ($allteam as $data) : ?>
                        <tbody>
                          <tr>
                            <td class="text-center"><?= $data->uid; ?></td>
                            <td class="text-center"><?= $data->fname; ?> <?= $data->lname; ?></td>
                            <td class="text-center"><?= $data->email_id; ?></td>
                            <td class="text-center"><?= $data->ac_status; ?></td>
                            <td class="text-center"><?= $data->date; ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('dashboard/edit_user'); ?>/<?= $data->uid; ?>" class="btn bg-primary"><i class="fas fa-edit small"></i> Edit user</a> 
                                <a href="<?= base_url('dashboard/delete_user'); ?>/<?= $data->uid; ?>" class="btn bg-danger" onclick="return confirm('Do you want to Archive user?')"><i class="fas fa-trash small"></i> Delete user</a>
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