<?php get_header(); ?>
<!-- TEMPLATE: archive-news.php -->
<div style="height: 8rem;"></div>

<section class="top_title_container">
  <div class="title_container">
    <h1>ニュース<span>News</span></h1>
    <p>JIT からのお知らせ・プレスリリース・最新情報をお届けします。</p>
  </div>
</section>

<?php
// 現在の絞り込み（/news/?nc=xxx）
$current_nc = isset($_GET['nc']) ? sanitize_title($_GET['nc']) : '';

// /news/ のURL
$archive_url = get_post_type_archive_link('news');

// タブURL作成（検索中なら検索条件も引き継ぐ）
$base_args = [];
if (!empty($_GET['s'])) $base_args['s'] = sanitize_text_field($_GET['s']);

// CSSクラスをタームslugで寄せる（既存CSSに合わせて調整）
function jit_news_cat_class($slug) {
  if ($slug === 'press') return 'cat-press';
  if ($slug === 'recruit') return 'cat-recruit';
  return 'cat-info'; // デフォルト
}

// データベースからニュースカテゴリーを取得（表示順の昇順でソート）
$news_categories = get_terms([
  'taxonomy' => 'news_category',
  'hide_empty' => false,
  'orderby' => 'meta_value_num',
  'meta_key' => 'news_category_order',
  'order' => 'ASC',
]);

// タブ配列を作成（「すべて」を最初に、その後にカテゴリー）
$tabs = ['' => 'すべて'];
if (!is_wp_error($news_categories) && !empty($news_categories)) {
  foreach ($news_categories as $category) {
    $tabs[$category->slug] = $category->name;
  }
}
?>

<section class="news_filter_section fadein">
  <div class="news_filter_inner">
    <ul class="news_filter_tabs">
      <?php foreach ($tabs as $slug => $label): ?>
        <?php
          $args = $base_args;
          if ($slug !== '') $args['nc'] = $slug;
          $url = add_query_arg($args, $archive_url);
          $is_active = ($current_nc === $slug);
          if ($slug === '' && $current_nc === '') $is_active = true;
        ?>
        <li class="<?php echo $is_active ? 'active' : ''; ?> hover_two">
          <a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="news_search_box">
      <form method="get" action="<?php echo esc_url($archive_url); ?>">
        <?php if (!empty($current_nc)): ?>
          <input type="hidden" name="nc" value="<?php echo esc_attr($current_nc); ?>">
        <?php endif; ?>
        <input type="text" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="キーワードで検索">
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>
  </div>
</section>

<section class="news_list_section fadein">
  <div class="news_list_inner">
    <ul class="news_list">
      <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
          <?php
            $terms = get_the_terms(get_the_ID(), 'news_category');
            $term  = (!is_wp_error($terms) && !empty($terms)) ? $terms[0] : null;

            $term_label = $term ? $term->name : '';
            $term_slug  = $term ? $term->slug : '';
            $cat_class  = $term ? jit_news_cat_class($term_slug) : '';

            $date = get_the_date('Y.m.d');
            $excerpt = get_the_excerpt();
            if (empty($excerpt)) $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 40);
          ?>
          <li class="news_item">
            <a href="<?php the_permalink(); ?>">
              <div class="news_meta">
                <span class="news_date"><?php echo esc_html($date); ?></span>
                <?php if (!empty($term_label)): ?>
                  <span class="news_cat <?php echo esc_attr($cat_class); ?>">
                    <?php echo esc_html($term_label); ?>
                  </span>
                <?php endif; ?>
              </div>
              <h2 class="news_title hover_one"><?php the_title(); ?></h2>
              <p class="news_excerpt"><?php echo esc_html($excerpt); ?></p>
            </a>
          </li>
        <?php endwhile; ?>
      <?php else: ?>
        <li class="news_item news_item_coming">
          <div class="news_coming_label">Coming soon...</div>
          <p>今後のニュース・プレスリリースをこちらに掲載していきます。</p>
        </li>
      <?php endif; ?>
    </ul>

    <div class="news_pagination">
      <?php
        $links = paginate_links([
          'type'      => 'array',
          'prev_next' => false,
        ]);
        if (!empty($links)) {
          foreach ($links as $l) {
            echo $l;
          }
        }
      ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>