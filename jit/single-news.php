<?php get_header(); ?>
<div style="height: 8rem;"></div>
<?php
// ループ開始
if (have_posts()):
  while (have_posts()):
    the_post();
    
    // ニュースカテゴリーを取得
    $terms = get_the_terms(get_the_ID(), 'news_category');
    $term = (!is_wp_error($terms) && !empty($terms)) ? $terms[0] : null;
    $term_label = $term ? $term->name : '';
    $term_slug = $term ? $term->slug : '';
    
    // カテゴリーのCSSクラスを決定（archive-news.phpと同じロジック）
    $cat_class = 'cat-info'; // デフォルト
    if ($term_slug === 'press') $cat_class = 'cat-prsudo rsync -av --delete /tmp/jit/ /var/www/html/wordpress/wp-content/themes/jit/ess';
    if ($term_slug === 'recruit') $cat_class = 'cat-recruit';
    
    // 日付を取得
    $date = get_the_date('Y.m.d');
    
    // アーカイブページのURL
    $archive_url = get_post_type_archive_link('news');
    
    // お問い合わせページのURL（固定ページのスラッグが'contact'の場合）
    $contact_url = get_permalink(get_page_by_path('contact'));
    if (!$contact_url) {
      $contact_url = home_url('/contact');
    }
?>
    <section class="top_title_container">
      <div class="title_container">
        <h1>ニュース<span>News</span></h1>
        <p>お知らせの詳細をご案内します。</p>
      </div>
    </section>

    <main class="news_detail_section fadein">
      <div class="news_detail_inner">

        <div class="news_breadcrumb">
          <a href="<?php echo esc_url($archive_url); ?>">ニュース</a>
          <?php if (!empty($term_label)): ?>
            / <?php echo esc_html($term_label); ?>
          <?php endif; ?>
        </div>

        <div class="news_detail_meta">
          <span class="news_date"><?php echo esc_html($date); ?></span>
          <?php if (!empty($term_label)): ?>
            <span class="news_cat <?php echo esc_attr($cat_class); ?>"><?php echo esc_html($term_label); ?></span>
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
          // カスタムフィールド 'news_points' が設定されている場合のみ表示
          $news_points = get_post_meta(get_the_ID(), 'news_points', true);
          if (!empty($news_points) && is_array($news_points)):
        ?>
          <section class="news_points">
            <h4>要点</h4>
            <dl>
              <?php foreach ($news_points as $point): ?>
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
          <a href="<?php echo esc_url($archive_url); ?>" class="hover_two">← ニュース一覧へ戻る</a>
        </div>

      </div>
    </main>
<?php
  endwhile;
endif;
?>
<?php get_footer(); ?>