<?php get_header(); ?>

<main class="contact">
  <div class="cmn-mv"></div>
  <!-- breadcrumb -->
  <?php if (function_exists('bcn_display')) : ?>
    <div class="breadcrumbs">
      <div class="inner">
        <?php bcn_display(); ?>
      </div>
    </div>
  <?php endif; ?>
  <!-- /.breadcrumb -->

  <div class="contact-section cmn-section">
    <div class="formarea">
      <h2 class="cmn-title">
        <p class="main">お問い合わせ</p>
        <span class="sub">Contact</span>
      </h2>
      <div class="contact-form">
      <!-- formから下を消して動的にする -->
        <?php
          while ( have_posts() ) {
            the_post();
            the_content();
          }
        ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer();
