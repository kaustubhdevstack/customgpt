<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// Header Template
$page_session = \Config\Services::session(); // starting and storing the user session

?>

<!DOCTYPE html>
<html>
        <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="author" content="DigiForge - digiforge.in">
                <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>/public/assets/img/logo/apple-touch-icon.png">
                <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/bootstrap.min.css"/>
                <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/adminlte.css"/>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"/>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
                <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/dataTables.bootstrap4.min.css">
                <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/responsive.bootstrap4.min.css">
                <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/bootstrap-slider.min"/>
                
                <title>Custom GPT</title>

                <script type="text/javascript">
                        var BASE_URL = "<?php echo base_url();?>"; // This will echo website URL
                </script>
        </head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

