<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Tool: Strategy Maker
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Strategy Maker</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('tools/strategy_maker'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Strategy Maker</li>
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
              <h3 class="card-title">Generate a Content calendar or Marketing Strategy</h3>
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
              
                <?= form_open('tools/strategy_maker'); ?>

                <div class="form-group row">
                  <div class="col-sm-12">
                      <?= csrf_field(); ?>
                  </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-6">
                        <label for="target-goal">What is your goal?</label>
                                <input type="text" class="form-control" id="target-goal" name="goal" value="<?= set_value('goal'); ?>" placeholder="Enter your goal for marketing" required>
                                <span class="text-danger"><?= display_err($validation, 'goal'); ?></span>
                        </div>

                        <div class="col-sm-6">
                        <label for="target-people">Your Target Audience?</label>
                                <input type="text" class="form-control" id="target-people" name="target" value="<?= set_value('target'); ?>" placeholder="Your target audience: Developers, Parents etc.." required>
                                <span class="text-danger"><?= display_err($validation, 'target'); ?></span>
                        </div>
                </div>


                <div class="form-group row">      
                        <div class="col-sm-6">
                        <label for="type">What you want?</label>
                        <select name="strategy" class="form-select form-control" aria-label="select-type" data-live-search="true" required>
                                <option disabled selected>Select what you want</option>
                                <option value="Blogging calendar">Blogging calendar</option>
                                <option value="Social media calendar">Social media calendar</option>
                                <option value="Digital Marketing Strategy">Digital Marketing Strategy</option>
                        </select>     
                        <span class="text-danger"><?= display_err($validation, 'strategy'); ?></span>
                        </div>

                        <div class="col-sm-6">
                        <label for="type">Duration?</label>
                        <select name="duration" class="form-select form-control" aria-label="select-type" data-live-search="true" required>
                                <option disabled selected>Select duration</option>
                                <option value="3 Months">3 Months</option>
                                <option value="6 Months">6 Months</option>
                                <option value="12 Months">12 Months</option>
                        </select>     
                        <span class="text-danger"><?= display_err($validation, 'strategy'); ?></span>
                        </div>   
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="cname">Business/Product/Service</label>
                                <input type="text" class="form-control" id="cname" name="cname" value="<?= set_value('cname'); ?>" placeholder="Write Business/product/service name" required>
                                <span class="text-danger"><?= display_err($validation, 'cname'); ?></span>
                        </div>
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="addPrompt">Explain what you are marketing</label>
                                <textarea name="describe" value="<?= set_value('describe'); ?>" class="form-control" id="addPrompt" placeholder="Need to know more.." required></textarea>
                                <span class="text-danger"><?= display_err($validation, 'describe'); ?></span>
                        </div>   
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Get your plans</button>
                    <a href="<?= base_url('tools/strategy_maker'); ?>" class="btn btn-dark">Cancel</a>
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