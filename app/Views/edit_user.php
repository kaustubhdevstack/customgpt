<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Edit team member
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard/edit_user'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Edit user</li>
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
<?php foreach ($allteam as $data) : ?>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit user account status</h3>
              </div><!-- /.card-header -->
              <div class="card-body">
              <?= form_open('dashboard/edit_user/' . $data->uid); ?>

                <div class="form-group row">
                        <div class="col-sm-12">
                                <?= csrf_field(); ?>
                        </div>
                </div>

                <label for="first-name" class="col-form-label">Full Name</label>
                <div class="form-group row">
                        <div class="col-sm-6">
                                <input type="text" class="form-control" id="first-name" placeholder="First Name" name="fname" value="<?= $data->fname; ?>" disabled>
                                <span class="text-danger"><?= display_err($validation, 'fname'); ?></span>
                        </div>
               
                        <div class="col-sm-6">
                                <input type="text" class="form-control" id="last-name" placeholder="Last Name" name="lname" value="<?= $data->lname; ?>" disabled>
                                <span class="text-danger"><?= display_err($validation, 'lname'); ?></span>
                        </div>
                </div>
                
                <label for="email" class="col-form-label">Email ID</label>
                <div class="form-group row">
                        <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email_id" value="<?= $data->email_id; ?>" placeholder="Enter email ID" disabled>
                                <span class="text-danger"><?= display_err($validation, 'email_id'); ?></span>
                        </div>
                </div>

                <div class="form-group row">      
                <label for="account-status">Account Status</label>
                        <div class="col-sm-12">
                        <select name="ac_status" class="form-select form-control" aria-label="select-status" data-live-search="true" required>
                                <option disabled selected>Select status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="blocked">Blocked</option>
                        </select>  
                        <span class="text-danger"><?= display_err($validation, 'ac_status'); ?></span>   
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
                                <button type="submit" class="btn btn-primary">Update User</button>
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
<?php endforeach; ?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->