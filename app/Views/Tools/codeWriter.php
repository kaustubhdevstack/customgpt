<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Tool: Code Writer
$page_session = \Config\Services::session(); // starting and storing the user session

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Code Writer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('tools/code_writer'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Code Writer</li>
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
              <h3 class="card-title">Write Code</h3>
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
              
                <?= form_open('tools/code_writer'); ?>

                <div class="form-group row">
                  <div class="col-sm-12">
                      <?= csrf_field(); ?>
                  </div>
                </div>

        
                <div class="form-group row">    
                        <div class="col-sm-12">
                        <label for="programming">Choose programming language</label>
                        <select name="programming" class="form-select form-control" aria-label="select-programming" data-live-search="true" required>
                                <option disabled selected>Select Programming Language</option>
                                <option value="CSS 3">CSS 3</option>
                                <option value="C++">C++</option>
                                <option value="C#">C#</option>
                                <option value="Java">Java</option>
                                <option value="Kotlin">Kotlin</option>
                                <option value="Javascript">Javascript</option>
                                <option value="JQuery">JQuery</option>
                                <option value="PHP 8">PHP 8</option>
                                <option value="Ajax">Ajax</option>
                                <option value="Codeigniter 4">Codeigniter 4</option>
                                <option value="Laravel 10">Laravel 10</option>
                                <option value="Python">Python</option>
                                <option value="Node JS">Node JS</option>
                                <option value="React">React</option>
                                <option value="Next JS 13">Next JS 13</option>
                                <option value="Golang">Golang</option>
                                <option value="Vue JS">Vue JS</option>
                                <option value="Flutter">Flutter</option>
                                <option value="Dart">Dart</option>
                                <option value="Swift">Swift</option>
                                <option value="Django">Django</option>
                                <option value="Flask">Flask</option>
                                <option value="Typescript">Typescript</option>
                                <option value="EJS">EJS</option>
                                <option value="Typescript">Typescript</option>
                                <option value="Bash script">Bash script</option>
                        </select>
                        <span class="text-danger"><?= display_err($validation, 'programming'); ?></span>
                        </div>           
                </div>

                <div class="form-group row">
                        <div class="col-sm-12">
                        <label for="addPrompt">Write proper instructions</label>
                                <textarea name="describe" value="<?= set_value('describe'); ?>" class="form-control" id="addPrompt" placeholder="Explain what kind of code you want" required></textarea>
                                <span class="text-danger"><?= display_err($validation, 'describe'); ?></span>
                        </div>   
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Write code</button>
                    <a href="<?= base_url('tools/code_writer'); ?>" class="btn btn-dark">Cancel</a>
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