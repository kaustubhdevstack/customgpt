<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Edit profile template
$page_session = \Config\Services::session(); // starting and storing the user session

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard/profile'); ?>">My Profile</a></li>
              <li class="breadcrumb-item active">Edit profile</li>
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
              <div class="card-header p-2">
                <ul class="nav nav-pills d-flex justify-content-center">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">User Information</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Profile Image</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <?= form_open('dashboard/edit_profile/' . $teamdata->uid); ?>
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                           <?= csrf_field(); ?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Your Name</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="inputName" value="<?= $teamdata->fname; ?> <?= $teamdata->lname; ?>" disabled>
                        </div>
                      </div>

                      <span class="text-danger"><?= display_err($validation, 'user_desg'); ?></span>
                      <div class="form-group row">
                        <label for="userDesignation" class="col-sm-2 col-form-label">Add your designation</label>
                        <div class="col-sm-12">
                          <input type="text" class="form-control" id="userDesignation" name="user_desg" value="<?= $teamdata->user_desg ?>" placeholder="Enter your designation">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I am Human!
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-12">
                          <button type="submit" class="btn btn-primary">Add Information</button>
                          <a href="<?= base_url('dashboard/edit_profile'); ?>" class="btn btn-dark">Cancel</a>
                        </div>
                      </div>
                    <?= form_close(); ?>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <?= form_open_multipart('dashboard/upload_avatar'); ?>
                    
                    <div class="form-group row">
                        <div class="col-sm-12">
                           <?= csrf_field(); ?>
                        </div>
                      </div>

                     <span class="text-danger"><?= display_err($validation, 'user_pic'); ?></span>
                      <div class="form-group row">
                        <label for="profileimage" class="col-sm-2 col-form-label">Upload Profile Picture</label>
                        <div class="col-sm-12">
                           <input class="form-control" type="file" id="profileimage" name="user_pic" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-12">
                          <button type="submit" name="upload" class="btn btn-primary">Upload Profile Picture</button>
                          <a href="<?= base_url('dashboard/edit_profile'); ?>" class="btn btn-dark">Cancel</a>
                        </div>
                      </div>
                    <?= form_close(); ?>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
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