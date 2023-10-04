<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Tool: Social Media Page Bio Maker
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Social Page Bio</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('tools/social_bio'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Social Page Bio</li>
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
              <h3 class="card-title">Generate a bio for Social Media Page</h3>
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
              
                <?= form_open('tools/social_bio'); ?>

                <div class="form-group row">
                  <div class="col-sm-12">
                      <?= csrf_field(); ?>
                  </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="brand">Page Name/Brand Name/Organization Name</label>
                                <input type="text" class="form-control" id="keywords" name="cname" value="<?= set_value('cname'); ?>" placeholder="Enter your reserched keywords" required>
                                <span class="text-danger"><?= display_err($validation, 'cname'); ?></span>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-4">
                        <label for="type">Select Type</label>
                        <select name="type" class="form-select form-control" aria-label="select-type" data-live-search="true" required>
                                <option disabled selected>Select Type</option>
                                <option value="Company">Company</option>
                                <option value="Business">Business</option>
                                <option value="Startup">Startup</option>
                                <option value="Freelancer">Freelancer</option>
                                <option value="Artist">Artist</option>
                                <option value="Non-Profit">Non-profit</option>
                                <option value="Government">Government</option>
                        </select>     
                        <span class="text-danger"><?= display_err($validation, 'tone'); ?></span>
                        </div>   

                        <div class="col-sm-4">
                        <label for="tone">Select Tone</label>
                        <select name="tone" class="form-select form-control" aria-label="select-tone" data-live-search="true" required>
                                <option disabled selected>Select Tone</option>
                                <option value="Informative">Informative</option>
                                <option value="Casual">Casual</option>
                                <option value="Professional">Professional</option>
                                <option value="Helpful">Helpful</option>
                                <option value="Awestruck">Awestruck</option> 
                                <option value="Passionate">Passionate</option>
                                <option value="Thoughtful">Thoughtful</option>
                                <option value="Urgent">Urgent</option>
                                <option value="Formal">Formal</option>
                                <option value="Cautionary">Cautionary</option>
                                <option value="Convincing">Convincing</option>
                                <option value="Joyful">Joyful</option>
                                <option value="Humorous">Humorous</option>
                                <option value="Funny">Funny</option>       
                                <option value="Humble">Humble</option>
                                <option value="Inspirational">Inspirational</option>
                                <option value="Fake">Fake</option>
                                <option value="Sarcastic">Sarcastic</option>
                        </select>     
                        <span class="text-danger"><?= display_err($validation, 'tone'); ?></span>
                        </div>   

                        <div class="col-sm-4">
                        <label for="platforms">Choose Platform</label>
                        <select name="platform" class="form-select form-control" aria-label="select-platform" data-live-search="true" required>
                                <option disabled selected>Select platform</option>
                                <option value="Linkedin">Linkedin Page</option>
                                <option value="Facebook">Facebook Page</option>
                                <option value="Medium">Medium</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Pinterest">Pinterest</option> 
                                <option value="Twitter">Twitter</option>
                                <option value="Youtube">Youtube</option>
                                <option value="Tiktok">Tiktok</option>
                        </select>     
                        <span class="text-danger"><?= display_err($validation, 'platform'); ?></span>
                        </div>   
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="addPrompt">Explain what you do?</label>
                                <textarea name="describe" value="<?= set_value('describe'); ?>" class="form-control" id="addPrompt" placeholder="Give a brief description on what you or your organization do" required></textarea>
                                <span class="text-danger"><?= display_err($validation, 'describe'); ?></span>
                        </div>   
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Get your Social Page Bio</button>
                    <a href="<?= base_url('tools/social_bio'); ?>" class="btn btn-dark">Cancel</a>
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