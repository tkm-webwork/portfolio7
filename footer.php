<footer class="footer cmn-section -primary">
  <div class="inner wow animate__animated animate__fadeIn" data-wow-offset="100">
    <div class="nav footer-nav">
      <nav class="nav-wrap">
        <ul class="nav-list">
          <li class="nav-item"><a href="#">利用規約</a></li>
          <li class="nav-item"><a href="#">プライバシーポリシー</a></li>
          <li class="nav-item"><a href="#">個人商取引法に基づく表記</a></li>
          <li class="nav-item"><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
        </ul>
      </nav>
      <div class="footer-logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/logo.png" alt="極楽亭"></a></div>
      <p class="copyright">Copyright &copy; 2021 極楽亭 All Rights Reserved.</p>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>