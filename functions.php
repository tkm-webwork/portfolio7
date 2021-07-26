<?php
global $NO_IMAGE_URL;

$NO_IMAGE_URL = '/image/noimg.png';

/**
 * WordPress標準機能
 *
 * @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_theme_support
 */
function my_setup() {
  add_theme_support( 'post-thumbnails' ); /* アイキャッチ */
  add_theme_support( 'automatic-feed-links' ); /* RSSフィード */
  add_theme_support( 'title-tag' ); /* タイトルタグ自動生成 */
  add_theme_support( 'html5', array( /* HTML5のタグで出力 */
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ) );
}
add_action( 'after_setup_theme', 'my_setup' );

/* CSSの読み込み
---------------------------------------------------------- */
function register_stylesheet() { //読み込むCSSを登録する
	wp_register_style('reset', get_template_directory_uri().'/css/reset.css');
	wp_register_style('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
	wp_register_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css');
	wp_register_style('style', get_template_directory_uri().'/css/style.css');
}
function add_stylesheet() { //登録したCSSを以下の順番で読み込む
	register_stylesheet();
	wp_enqueue_style('slick', '', array(), '1.0', false);
	wp_enqueue_style('animate', '', array(), '1.0', false);
	wp_enqueue_style('reset', '', array(), '1.0', false);
	wp_enqueue_style('style', '', array(), '1.0', false);
}
add_action('wp_enqueue_scripts', 'add_stylesheet');

/* スクリプトの読み込み
---------------------------------------------------------- */
function register_script(){ //読み込むJSを登録する
	wp_register_script('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js');
	wp_register_script('wow', get_stylesheet_directory_uri().'/js/wow.min.js');
	wp_register_script('script', get_template_directory_uri().'/js/script.js');
}
function add_script(){ //登録したJSを以下の順番で読み込む
	register_script();
	wp_enqueue_script('jquery');
	wp_enqueue_script('slick', '', array(), '1.0', true);
	wp_enqueue_script('wow', '', array(), '1.0', true);
	wp_enqueue_script('script', '', array(), '1.0', true);
}
add_action('wp_print_scripts','add_script');

/*パンくず
--------------------------------------------------------- */
function breadcrumb($postID) {
  $title = get_the_title($postID);//記事タイトル
  echo '<ol class="breadcrumb-list">';
  if ( is_single() ) {
    //詳細ページの場合
    echo '<li class="breadcrumb-item"><a href="/">ホーム</a></li>';
    echo '<li class="breadcrumb-item"><a href="/blog/">ブログ</a></li>';
    echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
  }
  else if( is_page() ) {
    //固定ページの場合
    echo '<li class="breadcrumb-item"><a href="/">ホーム</a></li>';
    echo '<li class="breadcrumb-item" aria-current="page">'.$title.'</li>';
  }
  echo "</ol>";
}

/*文字数の設定
------------------------------------------------------*/
function max_excerpt_length( $string, $maxLength) {
  $length = mb_strlen($string, 'UTF-8');
  if($length < $maxLength){
    return $string;
  } else {
    $string = mb_substr( $string , 0 , $maxLength, 'utf-8' );
    return $string.'[...]';
  }
}

/*ページネーション
---------------------------------------------------------*/
/*
使い方↓
$page_url = $_SERVER['REQUEST_URI'];//ページurlを取得
$page_url = strtok( $page_url, '?' );//パラメータは切り捨て
pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);

引数↓
@ $pages =>     ページ数
@ $term_id =>   タクソノミーID
@ $paged =>     現在のページ
@ $page_url =>  ページURL
@ $range =>     前後に何ページ分表示するか（引数が無ければ2ページ表示する）
*/
function pagination( $pages, $term_id, $paged, $page_url, $range = 2) {

  $pages = ( int ) $pages;//全てのページ数。float型で渡ってくるので明示的に int型 へ
  $paged = $paged ?: 1;//現在のページ
  $term_id = ( $term_id ) ? $term_id : 0;//タームID
  $s = $_GET['s'];//検索ワードを取得
  $search = ($s) ? '&s='.$s : '';//検索パラメータを制作

  if ($pages === 1 ) {
      // 1ページ以上の時 => 出力しない
      return;
  };

  if ( 1 !== $pages ) {
      //２ページ以上の時
      echo '<div class="inner">';
      if ( $paged > $range + 1 ) {
				// 一番初めのページへのリンク
				echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum=1'.$search.'"><span>1</span></a></div>';
        echo '<div class="dots"><span>...</span></div>';
			};
      for ( $i = 1; $i <= $pages; $i++ ) {
        //ページ番号の表示
        if ( $i <= $paged + $range && $i >= $paged - $range ) {
          if ( $paged == $i ) {
            //現在表示しているページ
            echo '<div class="number -current"><span>'.$i.'</span></div>';
          } else {
            //前後のページ
            echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='.$i.$search.'"><span>'.$i.'</span></a></div>';
          };
        };
      };
      if ( $paged < $pages - $range ) {
				// 一番最後のページへのリンク
        echo '<div class="dots"><span>...</span></div>';
        echo '<div class="number"><a href="'.$page_url.'?term_id='.$term_id.'&pagenum='. $pages.$search.'"><span>'. $pages .'</span></a></div>';
      }
      echo '</div>';
  };
};

/*title tagの出力変更
------------------------------------------------------*/
function correct_title($title){
  if(is_search()){
      $title['title'] = '検索結果：'.get_search_query();
  }elseif(is_404()){
      $title['title'] = 'お探しのページは見つかりません';
  }
  return $title;
}
add_filter('document_title_parts', 'correct_title');

/*titleの仕切りを変更
------------------------------------------------------*/
function change_title_separator($sep){
  $sep = '|';
  return $sep;
}
add_filter('document_title_separator', 'change_title_separator');