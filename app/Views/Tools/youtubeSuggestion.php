<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Tool: Youtube SUggestions
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Youtube Suggestions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('tools/youtube_suggestion'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Youtube Suggestion</li>
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
              <h3 class="card-title">Get ideas for youtube videos!</h3>
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
              <div class="mailbox-read-message">
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
              
                <?= form_open('tools/youtube_suggestion'); ?>

                <div class="form-group row">
                  <div class="col-sm-12">
                      <?= csrf_field(); ?>
                  </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="niche-target">Enter your channel's videos tab link</label>
                                <input type="text" name="ylink" value="<?= set_value('ylink'); ?>" class="form-control" id="niche-target" placeholder="For eg: https://youtube.com/channel-name/videos" required>
                                <span class="text-danger"><?= display_err($validation, 'ylink'); ?></span>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-6">
                        <label for="niche-target">What is your Niche?</label>
                                <input type="text" name="niche" value="<?= set_value('niche'); ?>" class="form-control" id="niche-target" placeholder="Enter your Niche" required>
                                <span class="text-danger"><?= display_err($validation, 'niche'); ?></span>
                        </div>

                        <div class="col-sm-6">
                        <label for="topic-target">What is your Topic?</label>
                                <input type="text" name="topic" value="<?= set_value('topic'); ?>" class="form-control" id="topic-target" placeholder="Enter your topic" required>
                                <span class="text-danger"><?= display_err($validation, 'topic'); ?></span>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Get ideas</button>
                                <a href="<?= base_url('tools/youtube_suggestion'); ?>" class="btn btn-dark">Cancel</a>
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