<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo("charset"); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        $default_description =
            "JAPAN INTER TRADING公式サイト。食品を通じて人と価値を繋ぐ架け橋となる総合商社。";
        $page_description = $default_description;

        if (is_front_page() || is_home()) {
            $page_description =
                "JAPAN INTER TRADINGは、世界に広がるネットワークと情報を活かし、幅広い食品の輸出入を手がける総合商社です。食を通じて人と価値をつなぎ、日本と世界の架け橋となります。";
        } elseif (is_page(["recruit", "採用情報"])) {
            $page_description =
                "JAPAN INTER TRADINGの採用情報ページです。募集ポジション、募集要項、選考フローをご案内しています。";
        } elseif (is_page(["company", "会社概要"])) {
            $page_description =
                "JAPAN INTER TRADINGの会社概要ページです。経営理念、沿革、代表メッセージ、企業情報をご紹介しています。";
        } elseif (is_page(["business", "事業内容"])) {
            $page_description =
                "JAPAN INTER TRADINGの事業内容ページです。食品分野を中心とした輸出入・国内外ネットワーク・バリューチェーンをご紹介しています。";
        } elseif (is_page(["contact", "お問い合わせ"])) {
            $page_description =
                "JAPAN INTER TRADINGへのお問い合わせページです。お取引や商品、採用に関するご相談を受け付けています。";
        }
        ?>
        <meta name="description" content="<?php echo esc_attr(
            $page_description,
        ); ?>">
        <meta name="keywords" content="JAPAN INTER TRADING, 食品商社, 総合商社, 食品輸出, 食品輸入, 食品調達, 販売支援, 日本食">
        <meta property="og:site_name" content="<?php echo esc_attr(
            get_bloginfo("name"),
        ); ?>">
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "<?php echo esc_js(get_bloginfo("name")); ?>",
            "url": "<?php echo esc_url(home_url("/")); ?>"
        }
        </script>
        <?php wp_head(); ?>
    </head>
    <body id="top" <?php body_class(); ?>>
        <?php
        $is_company = is_page(["company", "会社概要"]);
        $is_business = is_page(["business", "事業内容"]);
        $is_product = is_post_type_archive("product") || is_singular("product");
        $is_news = is_post_type_archive("news") || is_singular("news");
        $is_recruit = is_page(["recruit", "採用情報"]);
        $is_contact = is_page(["contact", "お問い合わせ"]);
        ?>
        <header>
            <div class="header sp_none">
                <div class="header_left">
                    <div class="header_logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/logo.webp">
                        <a href="<?php echo home_url(
                            "/",
                        ); ?>" class="bold">JAPAN INTER TRADING</a>
                    </div>
                    <a href="<?php echo home_url(
                        "/company",
                    ); ?>" class="under_line<?php echo $is_company
    ? " on"
    : ""; ?>">会社概要</a>
                    <a href="<?php echo home_url(
                        "/business",
                    ); ?>" class="under_line<?php echo $is_business
    ? " on"
    : ""; ?>">事業内容</a>
                    <a href="<?php echo get_post_type_archive_link(
                        "product",
                    ); ?>" class="under_line<?php echo $is_product
    ? " on"
    : ""; ?>">商品一覧</a>
                    <a href="<?php echo get_post_type_archive_link(
                        "news",
                    ); ?>" class="under_line<?php echo $is_news
    ? " on"
    : ""; ?>">ニュース</a>
                    <a href="<?php echo home_url(
                        "/recruit",
                    ); ?>" class="under_line<?php echo $is_recruit
    ? " on"
    : ""; ?>">採用情報</a>
                    <a href="<?php echo home_url(
                        "/contact",
                    ); ?>" class="under_line<?php echo $is_contact
    ? " on"
    : ""; ?>">お問い合せ</a>
                </div>
                <div class="header_right sp_none">
                    <div class="header_right_top">
                        <button type="button" class="js-lang-switch" data-lang="ja">日本語</button>
                        <button type="button" class="js-lang-switch" data-lang="en">English</button>
                        <span>|</span>
                        <button><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <div class="header_right_bottom">
                        <input type="text" placeholder="キーワードを入力">
                    </div>
                </div>
            </div>
            <div class="sp_header pc_none">
                <a href="<?php echo home_url(
                    "/",
                ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.webp"></a>
                <a href="<?php echo home_url(
                    "/",
                ); ?>" class="bold">JAPAN INTER TRADING</a>
                <i class="fa-solid fa-bars"></i>
            </div>
        </header>
	        <nav>
		          <ul class="nav">
            <li><a href="<?php echo home_url(
                "/company",
            ); ?>" class="under_line<?php echo $is_company
    ? " on"
    : ""; ?>">会社概要</a></li>
            <li><a href="<?php echo home_url(
                "/business",
            ); ?>" class="under_line<?php echo $is_business
    ? " on"
    : ""; ?>">事業内容</a></li>
            <li><a href="<?php echo get_post_type_archive_link(
                "product",
            ); ?>" class="under_line<?php echo $is_product
    ? " on"
    : ""; ?>">商品一覧</a></li>
            <li><a href="<?php echo get_post_type_archive_link(
                "news",
            ); ?>" class="under_line<?php echo $is_news
    ? " on"
    : ""; ?>">ニュース</a></li>
            <li><a href="<?php echo home_url(
                "/recruit",
            ); ?>" class="under_line<?php echo $is_recruit
    ? " on"
    : ""; ?>">採用情報</a></li>
            <li><a href="<?php echo home_url(
                "/contact",
            ); ?>" class="under_line<?php echo $is_contact
    ? " on"
    : ""; ?>">お問い合せ</a></li>
		          </ul>
		        </nav>
            <div id="google_translate_element" style="display:none;"></div>
            <script>
                (function () {
                    var translateScriptLoaded = false;
                    var translateScriptLoading = false;
                    var switches = document.querySelectorAll('.js-lang-switch');

                    function setTranslateCookie(lang) {
                        var value = '/ja/' + lang;
                        var expires = 'expires=' + new Date(Date.now() + 31536000000).toUTCString();
                        document.cookie = 'googtrans=' + value + '; path=/; ' + expires;
                        document.cookie = 'googtrans=' + value + '; domain=.' + location.hostname + '; path=/; ' + expires;
                    }

                    function getCurrentLang() {
                        var match = document.cookie.match(/(?:^|;\s*)googtrans=\/[^/]+\/([^;]+)/);
                        return match ? match[1] : 'ja';
                    }

                    function loadTranslateScript(callback) {
                        if (translateScriptLoaded) {
                            callback();
                            return;
                        }
                        if (translateScriptLoading) {
                            return;
                        }
                        translateScriptLoading = true;
                        window.googleTranslateElementInit = function () {
                            new google.translate.TranslateElement(
                                { pageLanguage: 'ja', includedLanguages: 'ja,en', autoDisplay: false },
                                'google_translate_element'
                            );
                            translateScriptLoaded = true;
                            translateScriptLoading = false;
                            callback();
                        };
                        var script = document.createElement('script');
                        script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
                        script.async = true;
                        document.head.appendChild(script);
                    }

                    function applyLanguage(lang) {
                        if (lang === 'ja') {
                            setTranslateCookie('ja');
                            location.reload();
                            return;
                        }
                        setTranslateCookie('en');
                        loadTranslateScript(function () {
                            location.reload();
                        });
                    }

                    switches.forEach(function (button) {
                        button.addEventListener('click', function () {
                            var lang = button.getAttribute('data-lang') || 'ja';
                            if (getCurrentLang() === lang) {
                                return;
                            }
                            applyLanguage(lang);
                        });
                    });

                    if (getCurrentLang() === 'en') {
                        loadTranslateScript(function () {});
                    }
                })();
            </script>
