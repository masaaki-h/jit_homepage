<?php get_header(); ?>
<!-- TEMPLATE: archive-product.php -->
<div style="height: 8rem;"></div>
    <div class="top_title_container">
      <div class="title_container">
        <h1>商品一覧<span>Products</span></h1>
        <p>
          世界10か国以上から、お客様のニーズに沿った食品・飲料・畜産品を調達。<br>
          カテゴリ別、原産国別、ブランド別の3つの切り口で、取扱い商品をご紹介します。
        </p>
      </div>
    </div>
    <main class="brand-page">
      <section class="brand-tabs">
        <div class="brand-tabs-inner">
          <button class="brand-tab-button" data-view="category">カテゴリ別</button>
          <button class="brand-tab-button" data-view="country">原産国別</button>
          <button class="brand-tab-button" data-view="brand">ブランド別</button>
        </div>
      </section>
      <section class="brand-views">
        <div class="brand-view" id="brand-category">
          <?php
          // カテゴリ別表示
          $categories = get_terms([
            'taxonomy' => 'product_category',
            'hide_empty' => false, // 空のカテゴリも表示
            'orderby' => 'term_order',
            'order' => 'ASC',
          ]);

          if (!is_wp_error($categories) && !empty($categories)) {
            foreach ($categories as $category) {
              // このカテゴリに属する商品を取得（WP_Queryを使用）
              $products_query = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => [
                  [
                    'taxonomy' => 'product_category',
                    'field' => 'term_id',
                    'terms' => $category->term_id,
                  ],
                ],
              ]);
              ?>
              <section class="brand-section fadein">
                <h2 class="brand-section-title"><?php echo esc_html($category->name); ?></h2>
                <?php if (!empty($category->description)): ?>
                  <p class="brand-section-desc">
                    <?php echo esc_html($category->description); ?>
                  </p>
                <?php endif; ?>

                <?php if ($products_query->have_posts()): ?>
                  <div class="brand-card-grid">
                    <?php while ($products_query->have_posts()): $products_query->the_post(); ?>
                      <?php
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $excerpt = get_the_excerpt();
                        if (empty($excerpt)) {
                          $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 40);
                        }
                        $countries = get_the_terms(get_the_ID(), 'product_country');
                        $country = (!is_wp_error($countries) && !empty($countries)) ? $countries[0] : null;
                        $country_slug = $country ? $country->slug : '';
                      ?>
                      <article class="brand-card hover_three">
                        <a href="<?php the_permalink(); ?>" style="display: flex; flex-direction: column; height: 100%; text-decoration: none; color: inherit;">
                          <div class="brand-card-thumb">
                            <?php if ($thumbnail): ?>
                              <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else: ?>
                              <div class="brand-card-thumb-placeholder">No Image</div>
                            <?php endif; ?>
                          </div>
                          <div class="brand-card-body">
                            <?php if ($country): ?>
                              <span class="brand-label-country <?php echo esc_attr($country_slug); ?>"><?php echo esc_html($country->name); ?></span>
                            <?php endif; ?>
                            <h3 class="brand-card-name"><?php the_title(); ?></h3>
                            <?php if (!empty($excerpt)): ?>
                              <p class="brand-card-desc">
                                <?php echo esc_html($excerpt); ?>
                              </p>
                            <?php endif; ?>
                          </div>
                        </a>
                      </article>
                    <?php endwhile; ?>
                  </div>
                <?php else: ?>
                  <p class="brand-section-desc" style="color: #999; font-style: italic;">
                    このカテゴリには商品が登録されていません。
                  </p>
                <?php endif; ?>
              </section>
              <?php
              wp_reset_postdata();
            }
          } else {
            // 商品が登録されていない場合
            ?>
            <section class="brand-section fadein">
              <h2 class="brand-section-title">カテゴリ別</h2>
              <p class="brand-section-desc">
                取扱い商品のカテゴリ別一覧は、現在準備中です。<br>
                掲載商品や商品カテゴリの詳細については、お気軽にお問合せください。
              </p>
            </section>
            <?php
          }
          ?>
        </div>
        <div class="brand-view" id="brand-country">
          <?php
          // 原産国別表示
          $countries = get_terms([
            'taxonomy' => 'product_country',
            'hide_empty' => false, // 空の原産国も表示
            'orderby' => 'term_order',
            'order' => 'ASC',
          ]);

          if (!is_wp_error($countries) && !empty($countries)) {
            foreach ($countries as $country) {
              // この原産国に属する商品を取得（WP_Queryを使用）
              $products_query = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => [
                  [
                    'taxonomy' => 'product_country',
                    'field' => 'term_id',
                    'terms' => $country->term_id,
                  ],
                ],
              ]);
              
              // 保存された国旗を取得
              $flag = get_term_meta($country->term_id, 'country_flag', true);
              ?>
              <section class="brand-section fadein">
                <h2 class="brand-section-title">
                  <?php if ($flag): ?>
                    <span class="brand-country-flag"><?php echo $flag; ?></span>
                  <?php endif; ?>
                  <?php echo esc_html($country->name); ?>
                </h2>
                <?php if ($products_query->have_posts()): ?>
                  <div class="brand-card-grid">
                    <?php while ($products_query->have_posts()): $products_query->the_post(); ?>
                      <?php
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $excerpt = get_the_excerpt();
                        if (empty($excerpt)) {
                          $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 40);
                        }
                        $categories = get_the_terms(get_the_ID(), 'product_category');
                        $category = (!is_wp_error($categories) && !empty($categories)) ? $categories[0] : null;
                      ?>
                      <article class="brand-card hover_three">
                        <a href="<?php the_permalink(); ?>" style="display: flex; flex-direction: column; height: 100%; text-decoration: none; color: inherit;">
                          <div class="brand-card-thumb">
                            <?php if ($thumbnail): ?>
                              <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else: ?>
                              <div class="brand-card-thumb-placeholder">No Image</div>
                            <?php endif; ?>
                          </div>
                          <div class="brand-card-body">
                            <?php if ($category): ?>
                              <span class="brand-label-country" style="background: rgba(0, 91, 172, 0.12); border-color: rgba(0, 91, 172, 0.4); color: #005bac;">
                                <?php echo esc_html($category->name); ?>
                              </span>
                            <?php endif; ?>
                            <h3 class="brand-card-name"><?php the_title(); ?></h3>
                            <?php if (!empty($excerpt)): ?>
                              <p class="brand-card-desc">
                                <?php echo esc_html($excerpt); ?>
                              </p>
                            <?php endif; ?>
                          </div>
                        </a>
                      </article>
                    <?php endwhile; ?>
                  </div>
                <?php else: ?>
                  <p class="brand-section-desc" style="color: #999; font-style: italic;">
                    この原産国には商品が登録されていません。
                  </p>
                <?php endif; ?>
              </section>
              <?php
              wp_reset_postdata();
            }
          } else {
            // 商品が登録されていない場合
            ?>
            <section class="brand-section fadein">
              <h2 class="brand-section-title">原産国別</h2>
              <p class="brand-section-desc">
                取扱い商品の原産国別一覧は、現在準備中です。<br>
                掲載商品や原産国の詳細については、お気軽にお問合せください。
              </p>
            </section>
            <?php
          }
          ?>
        </div>
        <div class="brand-view" id="brand-list">
          <?php
          // ブランド別表示
          $brands = get_terms([
            'taxonomy' => 'product_brand',
            'hide_empty' => false, // 空のブランドも表示
            'orderby' => 'term_order',
            'order' => 'ASC',
          ]);

          if (!is_wp_error($brands) && !empty($brands)) {
            foreach ($brands as $brand) {
              // このブランドに属する商品を取得（WP_Queryを使用）
              $products_query = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => [
                  [
                    'taxonomy' => 'product_brand',
                    'field' => 'term_id',
                    'terms' => $brand->term_id,
                  ],
                ],
              ]);
              
              ?>
              <section class="brand-section fadein">
                <h2 class="brand-section-title"><?php echo esc_html($brand->name); ?></h2>
                <?php if (!empty($brand->description)): ?>
                  <p class="brand-section-desc">
                    <?php echo esc_html($brand->description); ?>
                  </p>
                <?php endif; ?>

                <?php if ($products_query->have_posts()): ?>
                  <div class="brand-card-grid">
                    <?php while ($products_query->have_posts()): $products_query->the_post(); ?>
                      <?php
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $excerpt = get_the_excerpt();
                        if (empty($excerpt)) {
                          $excerpt = wp_trim_words(wp_strip_all_tags(get_the_content()), 40);
                        }
                        $countries = get_the_terms(get_the_ID(), 'product_country');
                        $country = (!is_wp_error($countries) && !empty($countries)) ? $countries[0] : null;
                        $country_slug = $country ? $country->slug : '';
                      ?>
                      <article class="brand-card hover_three">
                        <a href="<?php the_permalink(); ?>" style="display: flex; flex-direction: column; height: 100%; text-decoration: none; color: inherit;">
                          <div class="brand-card-thumb">
                            <?php if ($thumbnail): ?>
                              <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php else: ?>
                              <div class="brand-card-thumb-placeholder">No Image</div>
                            <?php endif; ?>
                          </div>
                          <div class="brand-card-body">
                            <?php if ($country): ?>
                              <span class="brand-label-country <?php echo esc_attr($country_slug); ?>"><?php echo esc_html($country->name); ?></span>
                            <?php endif; ?>
                            <h3 class="brand-card-name"><?php the_title(); ?></h3>
                            <?php if (!empty($excerpt)): ?>
                              <p class="brand-card-desc">
                                <?php echo esc_html($excerpt); ?>
                              </p>
                            <?php endif; ?>
                          </div>
                        </a>
                      </article>
                    <?php endwhile; ?>
                  </div>
                <?php else: ?>
                  <p class="brand-section-desc" style="color: #999; font-style: italic;">
                    このブランドには商品が登録されていません。
                  </p>
                <?php endif; ?>
              </section>
              <?php
              wp_reset_postdata();
            }
          } else {
            // ブランドが登録されていない場合
            ?>
            <section class="brand-section fadein">
              <h2 class="brand-section-title">ブランド別</h2>
              <p class="brand-section-desc">
                取扱いブランド別の一覧は、現在準備中です。<br>
                掲載ブランドや商品カテゴリの詳細については、お気軽にお問合せください。
              </p>
            </section>
            <?php
          }
          ?>
        </div>
      </section>
    </main>
<?php get_footer(); ?>

