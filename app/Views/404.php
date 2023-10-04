<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in

// Activate account template
include('Templates/header.php');
?>

<div class="hold-transition register-page">
  <section class="active-area">
      <div class="contact-form activate">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="contact__form__title mx-auto">
                          <h1 class="text-danger text-center text-bold">404</h1>
                          <p>The page you are looking for cannot be found</p>
                          <center><a href="<?= base_url('dashboard'); ?>" class="btn btn-primary"><i class="fas fa-tachometer-alt"></i> Dashboard</a></center>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
<?php include('Templates/footer.php'); ?>
<!-- /.register-box -->