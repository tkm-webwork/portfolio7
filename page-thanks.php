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
  <section class="contact-thanks">
    <div class="inner">
      <div class="thanks-text">
        <p>お問い合わせいただきありがとうございます。<br>内容を確認した後に、担当者よりご連絡を差し上げます。</p>
        <div class="link"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホームへ戻る</a></div>
      </div>
    </div>
  </section>
</main>

<?php get_footer();
