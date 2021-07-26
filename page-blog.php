<?php get_header(); ?>

<?php
$paged = $_GET['pagenum'];
global $NO_IMAGE_URL;
?>

<main class="article">
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

  <div class="article-section cmn-section">
    <div class="inner">
      <h2 class="cmn-title">
        <p class="main">ブログ</p>
        <span class="sub">blog</span>
      </h2>
      <div class="article-cont">
        <ul class="article-list">
        <!-- 記事のループを開始 -->
        <?php
        $args = array(
          'post_type' => 'post',
          'posts_per_page' => 10,
          'post_status'=> 'publish',
          'order'=>'DESC',
          'paged'=>$paged,
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : 
          while ( $the_query->have_posts() ) : $the_query->the_post();
          $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;//アイキャッチ画像を表示（設定されていない場合はデフォルト画像を表示）
          $link = get_permalink($post->ID);
          $data = get_the_modified_date( 'Y-m-d',$post->ID );
          $title = max_excerpt_length(get_the_title($post->ID) , 60);
          $desc = get_the_excerpt($post->ID);
          $category = get_the_category($post->ID)[0]->name;
        ?>


          <li class="article-item">
            <a href="<?php echo $link; ?>">
              <div class="article-text">
                <p class="time"><time datetime="<?php echo $data; ?>"><?php echo $data; ?></time></p>
                <div class="title"><?php echo $title; ?></div>
                <div class="desc"><?php echo $desc; ?></div>
              </div>
              <div class="article-image">
                <?php
                  if($category) {
                    echo '<p class="category">'.$category.'</p>';
                  };
                ?>
                <p class="image"><img src="<?php echo $thumbnail; ?>" alt=""></p>
              </div>
            </a>
          </li>
        
          <?php endwhile;
          endif;
          wp_reset_postdata();
          ?>
        </ul>
      </div>
      <div class="article-pager">
      <?php
        $page_url = $_SERVER['REQUEST_URI'];//ページurlを取得
        $page_url = strtok( $page_url, '?' );//パラメータは切り捨て
        $the_category_id = null;
        pagination($the_query->max_num_pages, $the_category_id, $paged, $page_url);//ページネーションを表示（functions.php）
      ?>
      </div>
    </div>
  </div>
</main>

<?php get_footer();
