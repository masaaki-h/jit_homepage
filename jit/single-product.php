<?php get_header(); ?>
<div style="height: 8rem;"></div>
<?php
// ループ開始
if (have_posts()):
  while (have_posts()):
    the_post();
    
    // 商品カテゴリーを取得
    $terms = get_the_terms(get_the_ID(), 'product_category');
    $term = (!is_wp_error($terms) && !empty($terms)) ? $terms[0] : null;
    $term_label = $term ? $term->name : '';
    $term_slug = $term ? $term->slug : '';
    
    // 日付を取得
    $date = get_the_date('Y.m.d');
    
    // アーカイブページのURL
    $archive_url = get_post_type_archive_link('product');
    
    // お問い合わせページのURL（固定ページのスラッグが'contact'の場合）
    $contact_url = get_permalink(get_page_by_path('contact'));
    if (!$contact_url) {
      $contact_url = home_url('/contact');
    }
?>
    <section class="top_title_container">
      <div class="title_container">
        <h1>商品<span>Product</span></h1>
        <p>商品の詳細をご案内します。</p>
      </div>
    </section>

    <main class="news_detail_section fadein">
      <div class="news_detail_inner">

        <div class="news_breadcrumb">
          <a href="<?php echo esc_url($archive_url); ?>">商品</a>
          <?php if (!empty($term_label)): ?>
            / <?php echo esc_html($term_label); ?>
          <?php endif; ?>
        </div>

        <div class="news_detail_meta">
          <span class="news_date"><?php echo esc_html($date); ?></span>
          <?php if (!empty($term_label)): ?>
            <span class="news_cat cat-info"><?php echo esc_html($term_label); ?></span>
          <?php endif; ?>
        </div>

        <h2 class="news_detail_title"><?php the_title(); ?></h2>

        <?php if (has_post_thumbnail()): ?>
          <div class="news_detail_eyecatch">
            <div class="eyecatch_frame">
              <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
            </div>
            <?php
              $caption = get_the_post_thumbnail_caption();
              if (!empty($caption)):
            ?>
              <div class="news_detail_caption"><?php echo esc_html($caption); ?></div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if (has_excerpt()): ?>
          <div class="news_detail_lead">
            <?php the_excerpt(); ?>
          </div>
        <?php endif; ?>

        <?php
          // 要点セクション（カスタムフィールドを使用する場合）
          // カスタムフィールド 'product_points' が設定されている場合のみ表示
          $product_points = get_post_meta(get_the_ID(), 'product_points', true);
          if (!empty($product_points) && is_array($product_points)):
        ?>
          <section class="news_points">
            <h4>要点</h4>
            <dl>
              <?php foreach ($product_points as $point): ?>
                <?php if (!empty($point['label']) && !empty($point['value'])): ?>
                  <dt><?php echo esc_html($point['label']); ?></dt>
                  <dd><?php echo esc_html($point['value']); ?></dd>
                <?php endif; ?>
              <?php endforeach; ?>
            </dl>
          </section>
        <?php endif; ?>

        <article class="news_detail_body">
          <?php the_content(); ?>
        </article>

        <section class="news_detail_cta hover_three">
          <h3>お問い合わせはこちら</h3>
          <p>お取引のご相談、商品に関するご質問などお気軽にご連絡ください。</p>
          <a class="news_cta_button" href="<?php echo esc_url($contact_url); ?>">お問い合せ</a>
        </section>

        <div class="news_detail_back">
          <a href="<?php echo esc_url($archive_url); ?>" class="hover_two">← 商品一覧へ戻る</a>
        </div>

      </div>
    </main>
<?php
  endwhile;
endif;
?>
<?php get_footer(); ?>

