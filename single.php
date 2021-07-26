<?php get_header(); ?>

<?php
global $NO_IMAGE_URL;
?>

<main class="single">
  <!-- breadcrumb -->
  <?php if (function_exists('bcn_display')) : ?>
    <div class="breadcrumbs">
      <div class="inner">
        <?php bcn_display(); ?>
      </div>
    </div>
  <?php endif; ?>
  <!-- /.breadcrumb -->
  <div class="single-section cmn-section">
    <div class="inner">
    <?php
    if(have_posts()):
      while(have_posts()): the_post();
      $title = get_the_title(); //記事タイトルを取得する
      $content = get_the_content(); //記事の本文を取得する
      $category = get_the_category($post->ID)[0]->name; //カテゴリーの中の一番目のものを取得する
      $data = get_the_modified_date( 'Y-m-d',$post->ID ); //更新日を取得する
      $link = get_permalink();
      $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;//アイキャッチ画像を表示（設定されていない場合はデフォルト画像を表示）
      $thumbID = get_post_thumbnail_id( $postID ); //アイキャッチのID
      $alt = get_post_meta($thumbID,'_wp_attachment_image_alt',true); //アイキャッチIDからaltを取得
      $categories = get_the_category(); //カテゴリ
      $categoryList = '';
      foreach( $categories as $val ){
        $categoryList = ($categoryList) ? $categoryList.','.$val->slug : $categoryList.$val->slug;
    };
    ?>

      <header class="single-title">
        <?php
          if($category) {
            echo '<div class="category">'.$category.'</div>';
          };
        ?>
        <h1 class="main"><?php echo $title; ?></h1>
      </header>
      <div class="entry">
        <article class="single-entry">
          <div class="wrapper">
            <div class="info">
            <?php
              // ソーシャルブックマークボタンを出力する
              if( function_exists('wp_social_bookmarking_light_output_e') ) {
                  wp_social_bookmarking_light_output_e();
              }
            ?>  
              <p class="time"><time datetime="<?php echo $data; ?>"><?php echo $data; ?></time></p>
            </div>
            <div class="body">
              <div class="image"><img src="<?php echo $thumbnail ?>" alt="<?php echo $alt; ?>"></div>
              <?php
                echo $content;
              ?>
            </div>
          </div>
        </article>
        <?php
          endwhile;
        else:
          // 記事がない場合
          echo 'すみません。お探しの記事は存在しません。';
        endif;
        ?>

        <!-- サイドバー -->
        <aside class="single-widget">
        <?php
        $args = array(
          'post_status'=> 'publish',
          'post_type'=> 'post',
          'order'=>'DESC',
          'posts_per_page'=>5,
          'orderby'=>'menu_order',
          'category_name'=>$categoryList,
        );
        
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : 
        ?>


          <div class="widget-relative widget-secion">
            <div class="title">関連記事</div>
            <div class="list">
            <?php
              while ( $the_query->have_posts() ) : $the_query->the_post(); 
              $link = get_permalink($post->ID);
              $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;//アイキャッチ画像を表示（設定されていない場合はデフォルト画像を表示）
              $title = get_the_title(); //記事タイトルを取得する
            ?>
              <div class="item">
                <a href="<?php echo $link; ?>">
                  <div class="image">
                    <img src="<?php echo $thumbnail; ?>" alt="">
                  </div>
                  <div class="title"><?php echo $title; ?></div>
                </a>
              </div>
              <?php
                endwhile;
              ?>
            </div>
          </div>
          <?php
            endif;
            wp_reset_postdata();
          ?>

          <?php
          $args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'post_status'=> 'publish',
            'order'=>'DESC',
            'tag'=>'recommend' //tagをここで指定している
          );
          $the_query = new WP_Query( $args );
          if ( $the_query->have_posts() ) : 
          ?>
          <div class="widget-relative widget-secion">
            <div class="title">おすすめの記事</div>
            <div class="list">
            <?php
              while ( $the_query->have_posts() ) : $the_query->the_post();
              $title = get_the_title($post->ID);
              $link = get_permalink($post->ID);
              $thumbnail = (get_the_post_thumbnail_url( $post->ID, 'medium' )) ? get_the_post_thumbnail_url( $post->ID, 'medium' ) : get_template_directory_uri().$NO_IMAGE_URL;//アイキャッチ画像を表示（設定されていない場合はデフォルト画像を表示）
            ?>
              <div class="item">
                <a href="<?php echo $link; ?>">
                  <div class="image">
                    <img src="<?php echo $thumbnail; ?>" alt="">
                  </div>
                  <div class="title"><?php echo $title; ?></div>
                </a>
              </div>
              <?php
                endwhile;
              ?>
            </div>
          </div>
          <?php
          endif;
          wp_reset_postdata();
          ?>
        </aside>
      </div>
    </div>
  </div>
</main>

<?php get_footer();