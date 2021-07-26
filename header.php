<?php
global $post, $_HEADER;

// URLを取得
$http = is_ssl() ? 'https' : 'http' . '://';
$_HEADER['url'] = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

//ディスクリプションを取得
$_HEADER['description'] = wp_trim_words(strip_shortcodes($post->post_content), 55);

//ogp画像を取得
$_HEADER['og_image'] = get_the_post_thumbnail_url($post->ID);

//ページタイトルを取得
if (is_single() || is_page()) {
  $_HEADER['title'] = (get_the_title($post->ID)) ? get_the_title($post->ID) : get_bloginfo('name');
} else {
  $_HEADER['title'] = get_bloginfo('name');
}

$og_image .= '?' . time(); // UNIXTIMEのタイムスタンプをパラメータとして付与（OGPのキャッシュ対策）

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset') ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta property="og:title" content="<?php echo $_HEADER['title']; ?>">
  <meta property="og:type" content="blog">
  <meta name="twitter:card" content="summary_large_image" />
  <meta property="og:url" content="<?php echo $_HEADER['url']; ?>">
  <meta property="og:image" content="<?php echo $_HEADER['og_image'] . $og_image; ?>">
  <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>">
  <meta property="og:description" content="<?php echo $_HEADER['description']; ?>">
  <meta property="og:locale" content="ja_JP">
  <meta name="description" content="<?php echo $_HEADER['description']; ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="canonical" href="<?php echo $_HEADER['url']; ?>">
  <!-- <title></title> -->
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <header class="header">
    <div class="header-fixed">
      <h1 class="header-logo"><a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/logo.png" alt="極楽亭"></a></h1>
      <button type="button" class="nav-btn js-hamburger" aria-label="メニュー" aria-controls="nav" aria-expanded="false"><span></span><span></span><span></span></button>
    </div>
    <div class="nav header-nav">
      <nav class="nav-wrap">
        <ul class="nav-list">
          <li class="nav-item"><a href="#">宿泊予約</a></li>
          <li class="nav-item"><a href="#">観光情報</a></li>
          <li class="nav-item"><a href="#">よくあるご質問</a></li>
          <li class="nav-item"><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
        </ul>
      </nav>
    </div>
  </header>