<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Profile Template
$page_session = \Config\Services::session(); // starting and storing the user session

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('dashboard/profile'); ?>">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
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
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-primary">
                <h3 class="widget-user-username"> <?= $teamdata->fname; ?> <?= $teamdata->lname; ?></h3>
                <h5 class="widget-user-desc"> <?= $teamdata->user_desg; ?></h5>
              </div>
              <div class="widget-user-image">
              <?php if($profilepic !== false && $profilepic->user_pic != '') : ?>
                <img class="img-circle elevation-2" src="<?= $profilepic->user_pic;?>" alt="Profile Pic">
              <?php else : ?>
                <img class="img-circle elevation-2" src="<?= base_url('public/assets/img/user.png'); ?>" alt="Profile Pic">
              <?php endif; ?>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Joined On</h5>
                      <span class="description-text"><?= $teamdata->date; ?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">Email ID</h5>
                      <span class="description-text"><?= $teamdata->email_id; ?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">User ID</h5>
                      <span class="description-text"><?= $teamdata->uid; ?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <br>
                <div class="d-flex justify-content-center">
                    <a href="<?= base_url('dashboard/edit_profile'); ?>" class="btn btn-primary btn-block">Edit Profile</a>
                </div>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills d-flex justify-content-center">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Email Settings</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Password Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <?= form_open('dashboard/update_email'); ?>

                      <div class="form-group row">
                        <div class="col-sm-12">
                           <?= csrf_field(); ?>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Current Email ID</label>
                        <div class="col-sm-12">
                          <input type="email" class="form-control" id="inputEmail" value="<?= $teamdata->email_id ?>" placeholder="Current email id" disabled>
                        </div>
                      </div>

                      <span class="text-danger"><?= display_err($validation, 'email_id'); ?></span>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">New Email ID</label>
                        <div class="col-sm-12">
                          <input type="email" class="form-control" id="inputEmail" name="email_id" placeholder="Enter new email id">
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
                          <button type="submit" class="btn btn-primary">Change Email</button>
                          <a href="<?= base_url('dashboard/profile'); ?>" class="btn btn-dark">Cancel</a>
                        </div>
                      </div>
                    <?= form_close(); ?>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <?= form_open('dashboard/update_password'); ?>

                      <div class="form-group row">
                        <div class="col-sm-12">
                           <?= csrf_field(); ?>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="currentPassword" class="col-form-label">Email ID</label>
                          <input type="email" class="form-control" id="inputEmail" value="<?= $teamdata->email_id; ?>" placeholder="Email" disabled>
                        </div>
                        
                        <div class="col-sm-4 mt-2">
                          <span class="text-danger"><?= display_err($validation, 'oldpasswd'); ?></span>
                          <label for="oldPassword" class="col-form-label">Enter Old Password</label>
                          <input type="password" class="form-control" id="oldPassword" name="oldpasswd" placeholder="Enter old password">
                        </div>

                        <div class="col-sm-4 mt-2">
                          <span class="text-danger"><?= display_err($validation, 'passwd'); ?></span>
                          <label for="newPassword" class="col-form-label">Enter New Password</label>
                          <input type="password" class="form-control" id="newPassword" name="passwd" placeholder="Enter new password">
                        </div>

                        <div class="col-sm-4 mt-2">
                          <span class="text-danger"><?= display_err($validation, 'cpassword'); ?></span>
                          <label for="confirmPassword" class="col-form-label">Confirm New Password</label>
                          <input type="password" class="form-control" id="confirmPassword" name="cpassword" placeholder="Confirm new password">
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
                          <button type="submit" class="btn btn-primary">Change Password</button>
                          <a href="<?= base_url('dashboard/profile'); ?>" class="btn btn-dark">Cancel</a>
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