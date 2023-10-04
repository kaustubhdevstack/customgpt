<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Activate account template
$page_session = \Config\Services::session(); // starting and storing the user session
?>

<div class="hold-transition register-page">
  <section class="active-area">
      <div class="contact-form activate">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="contact__form__title">
                          <?php if(isset($error)) : ?>
                            <div class="alert alert-danger">
                              <?= $error; ?>
                            </div>
                            <br>
                          <?php endif; ?>

                          <?php if(isset($success)) : ?>
                            <div class="alert alert-success">
                              <?= $success; ?>
                            </div>
                            <br>
                          <?php endif; ?>
                          <center><a href="<?= base_url('dashboard'); ?>" class="btn btn-primary"><i class="fas fa-tachometer-alt"></i> Go to dashboard</a></center>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
<!-- /.register-box -->