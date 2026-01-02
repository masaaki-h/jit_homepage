<?php get_header(); ?>
        <div class="top_img">
            <img src="<?php echo get_template_directory_uri(); ?>/img/top_img.webp" width="1920" height="1080" loading="lazy" alt="JAPAN INTER TRADING トップ画像" class="sp_none">
			<img src="<?php echo get_template_directory_uri(); ?>/img/sp_top_img.webp"  loading="lazy" alt="JAPAN INTER TRADING トップ画像" class="pc_none">
        </div>
        <div class="top_container fadein">
           <div class="top_container_logo">
                <img src="<?php echo get_template_directory_uri(); ?>/img/tenlogo.png" class="hover_two">
           </div>
           <p class="hover_two">人と人を繋ぐ。<br>あらゆるものが<br>飛び交う世界へ</p>
        </div>
        <div class="message_container fadein">
            <h2>世界の「食」と「人」を、つなぐ架け橋へ。</h2>
            <p>私たちは、個性を大切にする事業家として、
               <p>人と価値を結び、感謝の循環を生み出します。</p>
                <span class="spacer"></span>
               <p>流行に左右されない“普遍的な産業”として、</p>
               <p>生活に欠かせない食品を通じ、</p>
               <p>日本から世界へ、持続可能な未来を届けます。</p>
                <span class="spacer"></span>
               <p>スピードと柔軟性、そして精密さ。</p>
               <p>大手にできない挑戦を、私たちは黒子として支え、</p>
               <p>価値創造の架け橋となります。</p>
        </div>
        <div class="trade_container fadein">
            <div class="import_container">
                <div class="import_box">
                        <div class="border_box hover_two">
                            <a href="<?php echo get_post_type_archive_link('brand'); ?>"><h3>輸入商品</h3></a>
                        </div>
                </div>
            </div>
            <div class="export_container">
                <div class="export_box">
                    <div class="border_box hover_two">
                        <a href="<?php echo get_post_type_archive_link('brand'); ?>"><h3>輸出商品</h3></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="news_container fadein">
            <div class="news_top_box">
                <h2>News</h2>
                <a href="<?php echo get_post_type_archive_link('news'); ?>" class="hover_one"><p>ニュース一覧<span><i class="fa-solid fa-circle-arrow-right"></i></span></p></a>
            </div>
            <section class="news_list_section fadein">
            <div class="news_list_inner">
                <ul class="news_list">
                <?php
                // ニュースカテゴリのCSSクラスを取得する関数
                function jit_news_cat_class($slug) {
                  if ($slug === 'press') return 'cat-press';
                  if ($slug === 'recruit') return 'cat-recruit';
                  return 'cat-info'; // デフォルト
                }

                // 最新のニュース3件を取得
                $news_query = new WP_Query([
                  'post_type' => 'news',
                  'posts_per_page' => 3,
                  'orderby' => 'date',
                  'order' => 'DESC',
                ]);

                if ($news_query->have_posts()):
                  while ($news_query->have_posts()): $news_query->the_post();
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
                <?php
                  endwhile;
                  wp_reset_postdata();
                else:
                ?>
                <li class="news_item news_item_coming">
                  <div class="news_coming_label">Coming soon...</div>
                  <p>今後のニュース・プレスリリースをこちらに掲載していきます。</p>
                </li>
                <?php endif; ?>
            </section>
        </div>
        <div class="recruit_container fadein">
            <div class="recruit_left_box"></div>
            <div class="recruit_right_box">
                <h2>採用情報</h2>
                <p>見えないところで、世界を支える。<br>
                   その想いを共に紡ぐ仲間を募集しています。</p>
                    <a href="<?php echo home_url(); ?>/html/recruit.html" class="hover_two">採用情報一覧へ</a>
            </div>
        </div>
<?php get_footer(); ?>