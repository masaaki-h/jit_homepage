<?php
/**
 * JIT Theme functions
 */

add_action("wp_enqueue_scripts", function () {
    $base = get_template_directory_uri();

    // ベースCSS
    wp_enqueue_style("jit-stylesheet", $base . "/css/stylesheet.css", [], null);

    wp_enqueue_style(
        "jit-fontawesome",
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css",
        [],
        "6.5.2",
    );

    // ページ別CSS（表示中のページにだけ読み込み＝競合防止）
    // スラッグが英語以外の場合は is_page(['recruit','採用情報']) のように追加可能
    $page_styles = [
        "company.css" => function () {
            return is_page(["company", "会社概要"]);
        },
        "recruit.css" => function () {
            return is_page(["recruit", "採用情報"]);
        },
        "business.css" => function () {
            return is_page(["business", "事業内容"]);
        },
        "contact.css" => function () {
            return is_page(["contact", "お問い合わせ"]);
        },
        "news.css" => function () {
            return is_post_type_archive("news");
        },
        "brand.css" => function () {
            return is_post_type_archive("product");
        },
    ];
    foreach ($page_styles as $css => $condition) {
        if ($condition()) {
            wp_enqueue_style(
                "jit-" . str_replace(".css", "", $css),
                $base . "/css/" . $css,
                ["jit-stylesheet"],
                null,
            );
        }
    }

    // JS
    wp_enqueue_script("jquery");

    wp_enqueue_script(
        "jit-common",
        $base . "/js/common.js",
        ["jquery"],
        null,
        true,
    );
});

// テーマサポート：アイキャッチ画像を有効化
add_action("after_setup_theme", function () {
    add_theme_support("post-thumbnails");
    add_theme_support("title-tag");
});

add_filter("document_title_parts", function ($parts) {
    if (is_front_page() || is_home()) {
        $parts["title"] = "JAPAN INTER TRADING";
        unset($parts["tagline"]);
        return $parts;
    }

    if (is_page(["company", "会社概要"])) {
        $parts["title"] = "会社概要";
        return $parts;
    }

    if (is_page(["business", "事業内容"])) {
        $parts["title"] = "事業内容";
        return $parts;
    }

    if (is_page(["recruit", "採用情報"])) {
        $parts["title"] = "採用情報";
        return $parts;
    }

    if (is_page(["contact", "お問い合わせ"])) {
        $parts["title"] = "お問い合わせ";
        return $parts;
    }

    if (is_post_type_archive("news")) {
        $parts["title"] = "ニュース";
        return $parts;
    }

    if (is_post_type_archive("product")) {
        $parts["title"] = "商品一覧";
        return $parts;
    }

    return $parts;
});

add_action("init", function () {
    // --- News: カスタム投稿タイプ ---
    register_post_type("news", [
        "labels" => [
            "name" => "ニュース",
            "singular_name" => "ニュース",
            "add_new" => "新規追加",
            "add_new_item" => "ニュースを追加",
            "edit_item" => "ニュースを編集",
            "new_item" => "新しいニュース",
            "view_item" => "ニュースを表示",
            "search_items" => "ニュースを検索",
            "not_found" => "ニュースが見つかりません",
            "menu_name" => "ニュース",
        ],
        "public" => true,
        "has_archive" => "news",
        "rewrite" => ["slug" => "news", "with_front" => false],
        "menu_position" => 5,
        "menu_icon" => "dashicons-megaphone",
        "supports" => ["title", "editor", "excerpt", "thumbnail", "revisions"],
        "show_in_rest" => true,
    ]);

    // --- News Category: タブ（お知らせ/プレス/採用）用 ---
    register_taxonomy(
        "news_category",
        ["news"],
        [
            "labels" => [
                "name" => "ニュース分類",
                "singular_name" => "ニュース分類",
                "search_items" => "ニュース分類を検索",
                "all_items" => "ニュース分類一覧",
                "edit_item" => "ニュース分類を編集",
                "update_item" => "ニュース分類を更新",
                "add_new_item" => "ニュース分類を追加",
                "new_item_name" => "新しいニュース分類",
                "menu_name" => "ニュース分類",
            ],
            "public" => true,
            "hierarchical" => true, // タブっぽくしたいのでカテゴリー型
            "show_admin_column" => true,
            "show_in_rest" => true,
            "rewrite" => ["slug" => "news-category"],
        ],
    );

    // --- Product: カスタム投稿タイプ ---
    register_post_type("product", [
        "labels" => [
            "name" => "商品",
            "singular_name" => "商品",
            "add_new" => "新規追加",
            "add_new_item" => "商品を追加",
            "edit_item" => "商品を編集",
            "new_item" => "新しい商品",
            "view_item" => "商品を表示",
            "search_items" => "商品を検索",
            "not_found" => "商品が見つかりません",
            "menu_name" => "商品",
        ],
        "public" => true,
        "has_archive" => "products",
        "rewrite" => ["slug" => "products", "with_front" => false],
        "menu_position" => 6,
        "menu_icon" => "dashicons-cart",
        "supports" => ["title", "editor", "excerpt", "thumbnail", "revisions"],
        "show_in_rest" => true,
    ]);

    // --- Product Category: 商品カテゴリ ---
    register_taxonomy(
        "product_category",
        ["product"],
        [
            "labels" => [
                "name" => "商品カテゴリ",
                "singular_name" => "商品カテゴリ",
                "search_items" => "商品カテゴリを検索",
                "all_items" => "商品カテゴリ一覧",
                "edit_item" => "商品カテゴリを編集",
                "update_item" => "商品カテゴリを更新",
                "add_new_item" => "商品カテゴリを追加",
                "new_item_name" => "新しい商品カテゴリ",
                "menu_name" => "商品カテゴリ",
            ],
            "public" => true,
            "hierarchical" => true,
            "show_admin_column" => true,
            "show_in_rest" => true,
            "rewrite" => ["slug" => "product-category"],
        ],
    );

    // --- Product Country: 原産国 ---
    register_taxonomy(
        "product_country",
        ["product"],
        [
            "labels" => [
                "name" => "原産国",
                "singular_name" => "原産国",
                "search_items" => "原産国を検索",
                "all_items" => "原産国一覧",
                "edit_item" => "原産国を編集",
                "update_item" => "原産国を更新",
                "add_new_item" => "原産国を追加",
                "new_item_name" => "新しい原産国",
                "menu_name" => "原産国",
            ],
            "public" => true,
            "hierarchical" => true,
            "show_admin_column" => true,
            "show_in_rest" => true,
            "rewrite" => ["slug" => "product-country"],
        ],
    );

    // --- Product Brand: ブランド ---
    register_taxonomy(
        "product_brand",
        ["product"],
        [
            "labels" => [
                "name" => "ブランド",
                "singular_name" => "ブランド",
                "search_items" => "ブランドを検索",
                "all_items" => "ブランド一覧",
                "edit_item" => "ブランドを編集",
                "update_item" => "ブランドを更新",
                "add_new_item" => "ブランドを追加",
                "new_item_name" => "新しいブランド",
                "menu_name" => "ブランド",
            ],
            "public" => true,
            "hierarchical" => true,
            "show_admin_column" => true,
            "show_in_rest" => true,
            "rewrite" => ["slug" => "product-brand"],
        ],
    );
});

/**
 * パーマリンク更新系の「おまじない」：
 * テーマ有効化時に rewrite を更新して、/news/ や /products/ が効くようにする
 */
add_action("after_switch_theme", function () {
    flush_rewrite_rules();
});

/**
 * 原産国タクソノミーに国旗選択機能を追加
 */

// タクソノミーのメタデータを有効化
add_action("init", function () {
    register_meta("term", "country_flag", [
        "type" => "string",
        "single" => true,
        "show_in_rest" => true,
    ]);
});

// 国旗と国名・スラッグのマッピング
function jit_get_country_data()
{
    return [
        "" => ["name" => "", "slug" => ""],
        "🇫🇷" => ["name" => "フランス", "slug" => "france"],
        "🇪🇸" => ["name" => "スペイン", "slug" => "spain"],
        "🇮🇹" => ["name" => "イタリア", "slug" => "italy"],
        "🇹🇭" => ["name" => "タイ", "slug" => "thailand"],
        "🇯🇵" => ["name" => "日本", "slug" => "japan"],
        "🇺🇸" => ["name" => "アメリカ", "slug" => "united-states"],
        "🇬🇧" => ["name" => "イギリス", "slug" => "united-kingdom"],
        "🇩🇪" => ["name" => "ドイツ", "slug" => "germany"],
        "🇨🇳" => ["name" => "中国", "slug" => "china"],
        "🇰🇷" => ["name" => "韓国", "slug" => "south-korea"],
        "🇦🇺" => ["name" => "オーストラリア", "slug" => "australia"],
        "🇧🇷" => ["name" => "ブラジル", "slug" => "brazil"],
        "🇨🇦" => ["name" => "カナダ", "slug" => "canada"],
        "🇮🇳" => ["name" => "インド", "slug" => "india"],
        "🇲🇽" => ["name" => "メキシコ", "slug" => "mexico"],
        "🇳🇱" => ["name" => "オランダ", "slug" => "netherlands"],
        "🇵🇹" => ["name" => "ポルトガル", "slug" => "portugal"],
        "🇬🇷" => ["name" => "ギリシャ", "slug" => "greece"],
        "🇹🇷" => ["name" => "トルコ", "slug" => "turkey"],
        "🇻🇳" => ["name" => "ベトナム", "slug" => "vietnam"],
        "🇵🇭" => ["name" => "フィリピン", "slug" => "philippines"],
        "🇮🇩" => ["name" => "インドネシア", "slug" => "indonesia"],
        "🇲🇾" => ["name" => "マレーシア", "slug" => "malaysia"],
        "🇸🇬" => ["name" => "シンガポール", "slug" => "singapore"],
        "🇭🇰" => ["name" => "香港", "slug" => "hong-kong"],
        "🇹🇼" => ["name" => "台湾", "slug" => "taiwan"],
    ];
}

// 国旗の選択肢（表示用）
function jit_get_country_flags()
{
    $data = jit_get_country_data();
    $flags = [];
    foreach ($data as $flag => $info) {
        if ($flag === "") {
            $flags[$flag] = "国旗を選択";
        } else {
            $flags[$flag] = $flag . " " . $info["name"];
        }
    }
    return $flags;
}

// 原産国追加フォームに国旗選択フィールドを追加
add_action("product_country_add_form_fields", function () {
    $flags = jit_get_country_flags();
    $country_data = jit_get_country_data();
    ?>
    <div class="form-field term-flag-wrap">
      <label for="country_flag">国</label>
      <select name="country_flag" id="country_flag">
        <?php foreach ($flags as $value => $label): ?>
          <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html(
    $label,
); ?></option>
        <?php endforeach; ?>
      </select>
      <p class="description">※国を選択すると、名前とスラッグが自動入力されます。</p>
    </div>
    <script type="text/javascript">
    (function($) {
      var countryData = <?php echo json_encode($country_data); ?>;

      // 国が選択されたら自動で入力する
      $('#country_flag').on('change', function() {
        var flag = $(this).val();
        if (flag && countryData[flag]) {
          var data = countryData[flag];
          // 名前を自動入力（tag-nameフィールド）
          if ($('#tag-name').length) {
            $('#tag-name').val(data.name);
          }
          // スラッグを自動入力（tag-slugフィールド）
          if ($('#tag-slug').length) {
            $('#tag-slug').val(data.slug);
          }
        }
      });
    })(jQuery);
    </script>
    <?php
});

// 原産国編集フォームに国旗選択フィールドを追加
add_action("product_country_edit_form_fields", function ($term) {
    $flag = get_term_meta($term->term_id, "country_flag", true);
    $flags = jit_get_country_flags();
    $country_data = jit_get_country_data();
    ?>
    <tr class="form-field term-flag-wrap">
      <th scope="row">
        <label for="country_flag">国</label>
      </th>
      <td>
        <select name="country_flag" id="country_flag">
          <?php foreach ($flags as $value => $label): ?>
            <option value="<?php echo esc_attr($value); ?>" <?php selected(
    $flag,
    $value,
); ?>>
              <?php echo esc_html($label); ?>
            </option>
          <?php endforeach; ?>
        </select>
        <p class="description">※国を選択すると、名前とスラッグが自動入力されます。</p>
      </td>
    </tr>
    <script type="text/javascript">
    (function($) {
      var countryData = <?php echo json_encode($country_data); ?>;

      // 国が選択されたら自動で入力する
      $('#country_flag').on('change', function() {
        var flag = $(this).val();
        if (flag && countryData[flag]) {
          var data = countryData[flag];
          // 名前を自動入力（nameフィールド）
          if ($('#name').length) {
            $('#name').val(data.name);
          }
          // スラッグを自動入力（slugフィールド）
          if ($('#slug').length) {
            $('#slug').val(data.slug);
          }
        }
      });
    })(jQuery);
    </script>
    <?php
});

// 原産国追加時に国旗を保存
add_action("created_product_country", function ($term_id) {
    if (isset($_POST["country_flag"])) {
        update_term_meta(
            $term_id,
            "country_flag",
            sanitize_text_field($_POST["country_flag"]),
        );
    }
});

// 原産国更新時に国旗を保存
add_action("edited_product_country", function ($term_id) {
    if (isset($_POST["country_flag"])) {
        update_term_meta(
            $term_id,
            "country_flag",
            sanitize_text_field($_POST["country_flag"]),
        );
    }
});

// 原産国一覧テーブルに国旗カラムを追加
add_filter("manage_edit-product_country_columns", function ($columns) {
    $columns["flag"] = "国旗";
    return $columns;
});

add_filter(
    "manage_product_country_custom_column",
    function ($content, $column_name, $term_id) {
        if ($column_name === "flag") {
            $flag = get_term_meta($term_id, "country_flag", true);
            if ($flag) {
                return '<span style="font-size: 1.5em;">' .
                    esc_html($flag) .
                    "</span>";
            }
        }
        return $content;
    },
    10,
    3,
);

/**
 * 管理画面：商品一覧にフィルターを追加
 */
add_action("restrict_manage_posts", function ($post_type) {
    // 商品の一覧ページのみ
    if ($post_type !== "product") {
        return;
    }

    // 商品カテゴリフィルター
    $selected_category = isset($_GET["product_category"])
        ? $_GET["product_category"]
        : "";
    $categories = get_terms([
        "taxonomy" => "product_category",
        "hide_empty" => false,
    ]);

    if (!is_wp_error($categories) && !empty($categories)) {
        echo '<select name="product_category" id="product_category">';
        echo '<option value="">すべての商品カテゴリ</option>';
        foreach ($categories as $category) {
            printf(
                '<option value="%s"%s>%s</option>',
                esc_attr($category->slug),
                selected($selected_category, $category->slug, false),
                esc_html($category->name),
            );
        }
        echo "</select>";
    }

    // 原産国フィルター
    $selected_country = isset($_GET["product_country"])
        ? $_GET["product_country"]
        : "";
    $countries = get_terms([
        "taxonomy" => "product_country",
        "hide_empty" => false,
    ]);

    if (!is_wp_error($countries) && !empty($countries)) {
        echo '<select name="product_country" id="product_country">';
        echo '<option value="">すべての原産国</option>';
        foreach ($countries as $country) {
            printf(
                '<option value="%s"%s>%s</option>',
                esc_attr($country->slug),
                selected($selected_country, $country->slug, false),
                esc_html($country->name),
            );
        }
        echo "</select>";
    }
});

/**
 * 管理画面：商品一覧のフィルター処理
 */
add_action("parse_query", function ($query) {
    global $pagenow;

    // 管理画面の商品一覧ページのみ
    if (!is_admin() || $pagenow !== "edit.php") {
        return;
    }
    if (!isset($_GET["post_type"]) || $_GET["post_type"] !== "product") {
        return;
    }

    // 商品カテゴリフィルター
    if (!empty($_GET["product_category"])) {
        $query->query_vars["tax_query"][] = [
            "taxonomy" => "product_category",
            "field" => "slug",
            "terms" => sanitize_title($_GET["product_category"]),
        ];
    }

    // 原産国フィルター
    if (!empty($_GET["product_country"])) {
        $query->query_vars["tax_query"][] = [
            "taxonomy" => "product_country",
            "field" => "slug",
            "terms" => sanitize_title($_GET["product_country"]),
        ];
    }
});

/**
 * ニュースカテゴリーの順序管理
 */
// タクソノミーのメタデータを有効化
add_action("init", function () {
    register_meta("term", "news_category_order", [
        "type" => "integer",
        "single" => true,
        "show_in_rest" => true,
        "default" => 0,
    ]);
});

// ニュースカテゴリー追加フォームに順序フィールドを追加
add_action("news_category_add_form_fields", function () {
    ?>
    <div class="form-field term-order-wrap">
      <label for="news_category_order">表示順序</label>
      <input type="number" name="news_category_order" id="news_category_order" value="0" min="0" step="1">
      <p class="description">数値が小さいほど先に表示されます（0が最初）。</p>
    </div>
    <?php
});

// ニュースカテゴリー編集フォームに順序フィールドを追加
add_action("news_category_edit_form_fields", function ($term) {
    $order = get_term_meta($term->term_id, "news_category_order", true);
    if ($order === "") {
        $order = 0;
    }
    ?>
    <tr class="form-field term-order-wrap">
      <th scope="row">
        <label for="news_category_order">表示順序</label>
      </th>
      <td>
        <input type="number" name="news_category_order" id="news_category_order" value="<?php echo esc_attr(
            $order,
        ); ?>" min="0" step="1">
        <p class="description">数値が小さいほど先に表示されます（0が最初）。</p>
      </td>
    </tr>
    <?php
});

// ニュースカテゴリー追加時に順序を保存
add_action("created_news_category", function ($term_id) {
    if (isset($_POST["news_category_order"])) {
        update_term_meta(
            $term_id,
            "news_category_order",
            intval($_POST["news_category_order"]),
        );
    }
});

// ニュースカテゴリー更新時に順序を保存
add_action("edited_news_category", function ($term_id) {
    if (isset($_POST["news_category_order"])) {
        update_term_meta(
            $term_id,
            "news_category_order",
            intval($_POST["news_category_order"]),
        );
    }
});

// ニュースカテゴリー一覧テーブルに順序カラムを追加
add_filter("manage_edit-news_category_columns", function ($columns) {
    $columns["order"] = "表示順序";
    return $columns;
});

add_filter(
    "manage_news_category_custom_column",
    function ($content, $column_name, $term_id) {
        if ($column_name === "order") {
            $order = get_term_meta($term_id, "news_category_order", true);
            return $order !== "" ? esc_html($order) : "0";
        }
        return $content;
    },
    10,
    3,
);

// ニュースカテゴリー一覧を順序でソート可能にする
add_filter("manage_edit-news_category_sortable_columns", function ($columns) {
    $columns["order"] = "order";
    return $columns;
});

add_action("parse_term_query", function ($query) {
    if (!is_admin()) {
        return;
    }
    if (!isset($_GET["orderby"]) || $_GET["orderby"] !== "order") {
        return;
    }

    $query->query_vars["meta_key"] = "news_category_order";
    $query->query_vars["orderby"] = "meta_value_num";
});

// クイック編集に順序フィールドを追加
add_action(
    "quick_edit_custom_box",
    function ($column_name, $screen, $name) {
        if ($name !== "news_category" || $column_name !== "order") {
            return;
        } ?>
    <fieldset>
      <div class="inline-edit-col">
        <label>
          <span class="title">表示順序</span>
          <span class="input-text-wrap">
            <input type="number" name="news_category_order" class="ptitle" value="" min="0" step="1">
          </span>
        </label>
      </div>
    </fieldset>
    <?php
    },
    10,
    3,
);

// クイック編集用のJavaScriptを追加（順序値を設定）
add_action("admin_footer", function () {
    $screen = get_current_screen();
    if (!$screen || $screen->taxonomy !== "news_category") {
        return;
    }?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      var $inlineEditor = $('#inline-edit');
      var $bulkEditor = $('#bulk-edit');

      // クイック編集を開いたときに順序値を設定
      $(document).on('click', '.editinline', function() {
        var $row = $(this).closest('tr');
        //var termId = $row.attr('id').replace('tag-', '');
        var order = $row.find('.column-order').text().trim();

        $inlineEditor.find('input[name="news_category_order"]').val(order || '0');
      });

      // クイック編集の保存処理
      var originalInlineSave = window.inlineEditTax.save;
      window.inlineEditTax.save = function(id) {
        var termId = String(id).replace('tag-', '');
        var order = $('#inline-edit').find('input[name="news_category_order"]').val();

        // 元の保存処理を実行
        originalInlineSave.apply(this, arguments);

        // 順序値を保存（AJAXで保存）
        if (order !== undefined && order !== '') {
          $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
              action: 'save_news_category_order',
              term_id: termId,
              order: order
            }
          });
        }
      };
    });
    </script>
    <?php
});

// クイック編集での順序保存を処理
add_action("wp_ajax_save_news_category_order", function () {
    check_ajax_referer("taxinlineeditnonce", "_inline_edit");

    $term_id = isset($_POST["term_id"]) ? intval($_POST["term_id"]) : 0;
    $order = isset($_POST["order"]) ? intval($_POST["order"]) : 0;

    if ($term_id > 0) {
        update_term_meta($term_id, "news_category_order", $order);
        wp_send_json_success(["message" => "順序を更新しました"]);
    } else {
        wp_send_json_error(["message" => "無効なタームIDです"]);
    }
});

/**
 * ニュースアーカイブページのタブ絞り込み
 */
add_action("pre_get_posts", function ($q) {
    if (is_admin() || !$q->is_main_query()) {
        return;
    }

    // news のアーカイブだけ対象
    if (!$q->is_post_type_archive("news")) {
        return;
    }

    // タブ絞り込み：/news/?nc=slug
    if (!empty($_GET["nc"])) {
        $slug = sanitize_title($_GET["nc"]);
        $q->set("tax_query", [
            [
                "taxonomy" => "news_category",
                "field" => "slug",
                "terms" => [$slug],
            ],
        ]);
    }

    // 1ページ表示数（必要なら調整）
    $q->set("posts_per_page", 5);
});
