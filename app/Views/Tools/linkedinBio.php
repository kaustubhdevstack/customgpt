<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Tool: Linkedin Profile Bio Maker
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Linkedin Bio Maker</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('tools/extract_keyword'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Linkedin Bio Maker</li>
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
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Linkedin Bio Maker</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-2">
                <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-container="body" id="copy-button">
                    <i class="fas fa-copy"></i>
                    Copy Result
                  </button>
                  <a href="<?= base_url('history/usage_history');?>" class="btn btn-default btn-sm" data-container="body" id="history">
                    <i class="fas fa-eye"></i>
                    Check History
                  </a>
                </div>
                <!-- /.btn-group -->
              </div>
              <!-- /.mailbox-controls -->
              <div id="resultAI" class="mailbox-read-message">
                <p class="text-center"><b>Your result will be displayed here</b></p>

                  
                <!-- /.displaying AI results -->
                <?php if(isset($resultTxt)) { ?>
                        <pre><?= $resultTxt; ?></pre>
                <?php } ?>

                <!-- /.displaying AI results -->


              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            <!-- /.card-footer -->
            <div class="card-footer">
              
                <?= form_open('tools/linkedin_bio'); ?>

                <div class="form-group row">
                  <div class="col-sm-12">
                      <?= csrf_field(); ?>
                  </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-4">
                        <label for="job">What is your profession?</label>
                                <input type="text" class="form-control" id="job" name="profession" value="<?= set_value('profession'); ?>" placeholder="I am a fresher or experienced developer etc.." required>
                                <span class="text-danger"><?= display_err($validation, 'profession'); ?></span>
                        </div>

                        <div class="col-sm-4">
                        <label for="skillset">Your skill?</label>
                                <input type="text" class="form-control" id="skillset" name="skills" value="<?= set_value('skills'); ?>" placeholder="Enter your skills" required>
                                <span class="text-danger"><?= display_err($validation, 'skills'); ?></span>
                        </div>

                        <div class="col-sm-4">
                        <label for="tone">Select Tone</label>
                        <select name="tone" class="form-select form-control" aria-label="select-tone" data-live-search="true" required>
                                <option disabled selected>Select Tone</option>
                                <option value="Casual">Casual</option>
                                <option value="Professional">Professional</option>
                                <option value="Formal">Formal</option>
                                <option value="Inspirational">Inspirational</option>
                        </select>     
                        <span class="text-danger"><?= display_err($validation, 'tone'); ?></span>
                        </div>   
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="addPrompt">Explain or describe your achievements</label>
                                <textarea name="describe" value="<?= set_value('describe'); ?>" class="form-control" id="addPrompt" placeholder="Write something about you" required></textarea>
                                <span class="text-danger"><?= display_err($validation, 'describe'); ?></span>
                        </div>   
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Get your bio</button>
                    <a href="<?= base_url('tools/title_maker'); ?>" class="btn btn-dark">Cancel</a>
                  </div>
                </div>

                <?= form_close(); ?>
            </div>
            <!-- /.card-footer -->
          </div>
          </div><!-- /.card -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->