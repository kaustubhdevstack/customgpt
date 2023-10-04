<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Add new user
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Team</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard/add_user'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Add user</li>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add Team Member</h3>
              </div><!-- /.card-header -->
              <div class="card-body">
              <?= form_open('dashboard/add_user'); ?>

                <div class="form-group row">
                        <div class="col-sm-12">
                                <?= csrf_field(); ?>
                        </div>
                </div>

               
                <div class="form-group row">
                        <div class="col-sm-6">
                        <span class="text-danger"><?= display_err($validation, 'First Name'); ?></span>
                        <label for="first-name" class="col-sm-2 col-form-label">First Name</label>
                                <input type="text" class="form-control" id="first-name" placeholder="First Name" name="fname" value="<?= set_value('fname'); ?>" required>
                        </div>
                
                        <div class="col-sm-6">
                        <span class="text-danger"><?= display_err($validation, 'Last Name'); ?></span>
                        <label for="last-name" class="col-sm-2 col-form-label">Last Name</label>
                                <input type="text" class="form-control" id="last-name" placeholder="Last Name" name="lname" value="<?= set_value('lname'); ?>" required>
                        </div>
                </div>

                <span class="text-danger"><?= display_err($validation, 'email_id'); ?></span>
                <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Add User Email ID</label>
                        <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email_id" value="<?= set_value('email_id'); ?>" placeholder="Enter email ID">
                        </div>
                </div>
                
                <div class="form-group row">
                        <div class="col-sm-6">
                        <span class="text-danger"><?= display_err($validation, 'passwd'); ?></span>
                        <label for="password">Copy paste password here</label>
                                <input type="password" class="form-control" id="passd" name="passwd" value="<?= set_value('passwd'); ?>" placeholder="Enter Generated Password">
                        </div>

                        <div class="col-sm-6">
                        <label for="autoGen">Auto Generated Password (Save it)</label>
                                <input type="text" class="form-control input-lg" name="genPass" placeholder="Auto Generated Password" rel="gp" data-size="32" data-character-set="a-z,A-Z,0-9,#" required>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                                <div class="icheck-primary mb-1 mt-1 float-left">
                                        <input type="checkbox" id="remember" required>
                                                <label for="remember">
                                                        I am Human!
                                                </label>
                                </div>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Add new member</button>
                                <a href="<?= base_url('dashboard/edit_profile'); ?>" class="btn btn-dark">Cancel</a>
                        </div>
                </div>
                <?= form_close(); ?>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->