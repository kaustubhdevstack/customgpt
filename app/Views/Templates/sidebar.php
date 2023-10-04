<?php

// App Name: Custom GPT
// Author: DigiForge 
// App version: 1.0
// App url: https://digiforge.in
// HTML Template: Admin LTE 3 (https://adminlte.io)

// Dashboard sidebar template

?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-3">
    <!-- Brand Logo -->

    <a href="<?= base_url('dashboard'); ?>" class="brand-link logo-switch">
      <img src="<?= base_url('/public/assets/img/logo/cgpt_logo.png'); ?>" alt="AdminLTE Docs Logo Small" class="brand-image-xl logo-xs">
      <img src="<?= base_url('/public/assets/img/logo/cgpt_logo.png'); ?>" alt="AdminLTE Docs Logo Large" class="brand-image-xs logo-xl">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php if($profilepic !== false && $profilepic->user_pic != '') : ?>
          <img class="img-circle" src="<?= $profilepic->user_pic;?>" alt="Profile Pic">
        <?php else : ?>
          <img class="img-circle" src="<?= base_url('public/assets/img/user.png'); ?>" alt="Profile Pic">
        <?php endif; ?>
        </div>
        <div class="info">
          <a href="<?= base_url('dashboard/profile'); ?>" class="d-block"><?= $teamdata->fname; ?> <?= $teamdata->lname; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt text-info"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('dashboard');?>" class="nav-link <?= (current_url() == base_url('dashboard')) ? 'active': ''; ?>" href="<?= base_url('dashboard');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Home</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('dashboard/profile');?>" class="nav-link <?= (current_url() == base_url('dashboard/profile')) ? 'active': ''; ?>" href="<?= base_url('dashboard/profile');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>My Profile</p>
                </a>
              </li>
            </ul>
          </li>
          <?php if($teamdata->usr_type == 'team' || $teamdata->ac_status == 'inactive') : ?>
          <?php else: ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users text-info"></i>
              <p>
                Team Members
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('dashboard/team');?>" class="nav-link <?= (current_url() == base_url('dashboard/team')) ? 'active': ''; ?>" href="<?= base_url('dashboard/team');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Team List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('dashboard/team_archive');?>" class="nav-link <?= (current_url() == base_url('dashboard/team_archive')) ? 'active': ''; ?>" href="<?= base_url('dashboard/team_archive');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Team Archive</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif; ?>

          <?php if($teamdata->ac_status == 'inactive') : ?>
          <?php else: ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tv text-info"></i>
              <p>
                Content AI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('tools/title_maker');?>" class="nav-link <?= (current_url() == base_url('tools/title_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/title_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Creative Title Maker</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/ecom_title');?>" class="nav-link <?= (current_url() == base_url('tools/ecom_title')) ? 'active': ''; ?>" href="<?= base_url('tools/ecom_title');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Ecommerce Title Maker</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?= base_url('tools/topic_suggestion');?>" class="nav-link <?= (current_url() == base_url('tools/topic_suggestion')) ? 'active': ''; ?>" href="<?= base_url('tools/topic_suggestion');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Topic Suggest</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/youtube_suggestion');?>" class="nav-link <?= (current_url() == base_url('tools/youtube_suggestion')) ? 'active': ''; ?>" href="<?= base_url('tools/youtube_suggestion');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Youtube Suggest</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/shortvid_suggestion');?>" class="nav-link <?= (current_url() == base_url('tools/shortvid_suggestion')) ? 'active': ''; ?>" href="<?= base_url('tools/shortvid_suggestion');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Short Video Suggest</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/outline_maker');?>" class="nav-link <?= (current_url() == base_url('tools/outline_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/outline_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Create Content Outline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/description_maker');?>" class="nav-link <?= (current_url() == base_url('tools/description_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/description_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Description Maker</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/meta_description');?>" class="nav-link <?= (current_url() == base_url('tools/meta_description')) ? 'active': ''; ?>" href="<?= base_url('tools/meta_description');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Meta Description Maker</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/content_fix');?>" class="nav-link <?= (current_url() == base_url('tools/content_fix')) ? 'active': ''; ?>" href="<?= base_url('tools/content_fix');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Improve/Fix Content</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bullhorn text-info"></i>
              <p>
               Marketing AI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('tools/email_writer');?>" class="nav-link <?= (current_url() == base_url('tools/email_writer')) ? 'active': ''; ?>" href="<?= base_url('tools/email_writer');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Email Writer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/extract_keyword');?>" class="nav-link <?= (current_url() == base_url('tools/extract_keyword')) ? 'active': ''; ?>" href="<?= base_url('tools/extract_keyword');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Extract Keyword</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/linkedin_bio');?>" class="nav-link <?= (current_url() == base_url('tools/linkedin_bio')) ? 'active': ''; ?>" href="<?= base_url('tools/linkedin_bio');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Linkedin Bio</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/social_bio');?>" class="nav-link <?= (current_url() == base_url('tools/social_bio')) ? 'active': ''; ?>" href="<?= base_url('tools/social_bio');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Social Media Page Bio</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/tweet_maker');?>" class="nav-link <?= (current_url() == base_url('tools/tweet_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/tweet_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Tweet Maker</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/insta_captions_maker');?>" class="nav-link <?= (current_url() == base_url('tools/insta_captions_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/insta_captions_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Insta Captions Maker</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/hashtag_maker');?>" class="nav-link <?= (current_url() == base_url('tools/hashtag_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/hashtag_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Create Viral Hastags</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/review_maker');?>" class="nav-link <?= (current_url() == base_url('tools/review_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/review_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Review Generator</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/strategy_maker');?>" class="nav-link <?= (current_url() == base_url('tools/strategy_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/strategy_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Strategy Maker</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/meme_maker');?>" class="nav-link <?= (current_url() == base_url('tools/meme_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/meme_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Meme Maker</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/google_ads');?>" class="nav-link <?= (current_url() == base_url('tools/google_ads')) ? 'active': ''; ?>" href="<?= base_url('tools/google_ads');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Google Ads</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/meta_ads');?>" class="nav-link <?= (current_url() == base_url('tools/meta_ads')) ? 'active': ''; ?>" href="<?= base_url('tools/meta_ads');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Meta Ads</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/linkedin_ads');?>" class="nav-link <?= (current_url() == base_url('tools/linkedin_ads')) ? 'active': ''; ?>" href="<?= base_url('tools/linkedin_ads');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Linkedin Ads</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-code text-info"></i>
              <p>
               Code AI
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('tools/code_writer');?>" class="nav-link <?= (current_url() == base_url('tools/code_writer')) ? 'active': ''; ?>" href="<?= base_url('tools/code_writer');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Code Writer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/regex_maker');?>" class="nav-link <?= (current_url() == base_url('tools/regex_maker')) ? 'active': ''; ?>" href="<?= base_url('tools/regex_maker');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Create Regex Validations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/review_code');?>" class="nav-link <?= (current_url() == base_url('tools/review_code')) ? 'active': ''; ?>" href="<?= base_url('tools/review_code');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Review Code</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/fix_code');?>" class="nav-link <?= (current_url() == base_url('tools/fix_code')) ? 'active': ''; ?>" href="<?= base_url('tools/fix_code');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Fix Code</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/improve_code');?>" class="nav-link <?= (current_url() == base_url('tools/improve_code')) ? 'active': ''; ?>" href="<?= base_url('tools/improve_code');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Improve Code Quality</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/secure_code');?>" class="nav-link <?= (current_url() == base_url('tools/secure_code')) ? 'active': ''; ?>" href="<?= base_url('tools/secure_code');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Secure Code</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/convert_code');?>" class="nav-link <?= (current_url() == base_url('tools/convert_code')) ? 'active': ''; ?>" href="<?= base_url('tools/convert_code');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Convert Code</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('tools/generate_sql');?>" class="nav-link <?= (current_url() == base_url('tools/generate_sql')) ? 'active': ''; ?>" href="<?= base_url('tools/generate_sql');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Generate SQL/MySQL</p>
                </a>
              </li>
            </ul>      
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-history text-info"></i>
              <p>
               My Usage Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('history/usage_history');?>" class="nav-link <?= (current_url() == base_url('history/usage_history')) ? 'active': ''; ?>" href="<?= base_url('history/usage_history');?>">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>All history</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>