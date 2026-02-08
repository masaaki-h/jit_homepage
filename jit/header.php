<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>JAPAN INTER TRADING</title> 
        <meta name="description" content="JAPAN INTER TRADING公式サイト。食品を通じて人と価値を繋ぐ架け橋となる総合商社。">
        <meta name="keywords" content="食品商社, 総合商社, JAPAN INTER TRADING, 10周年, 食品輸出, 食品輸入">
        <?php wp_head(); ?>
    </head>
    <body id="top" <?php body_class(); ?>>
        <header>
            <div class="header sp_none">
                <div class="header_left">
                    <div class="header_logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/logo.webp">
                        <a href="<?php echo home_url('/'); ?>" class="bold">JAPAN INTER TRADING</a>
                    </div>
                    <a href="<?php echo home_url('/company'); ?>" class="under_line">会社概要</a>
                    <a href="<?php echo home_url('/business'); ?>" class="under_line">事業内容</a>
                    <a href="<?php echo get_post_type_archive_link('product'); ?>" class="under_line on">商品一覧</a>
                    <a href="<?php echo get_post_type_archive_link('news'); ?>" class="under_line">ニュース</a>
                    <a href="<?php echo home_url('/recruit'); ?>" class="under_line">採用情報</a>
                    <a href="<?php echo home_url('/contact'); ?>" class="under_line">お問い合せ</a>
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
                <a href="<?php echo home_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.webp"></a>
                <a href="<?php echo home_url('/'); ?>" class="bold">JAPAN INTER TRADING</a>
                <i class="fa-solid fa-bars"></i>    
            </div>
        </header>
	        <nav>
	          <ul class="nav">
            <li><a href="<?php echo home_url('/company'); ?>" class="under_line">会社概要</a></li>
            <li><a href="<?php echo home_url('/business'); ?>" class="under_line">事業内容</a></li>
            <li><a href="<?php echo get_post_type_archive_link('product'); ?>" class="under_line on">商品一覧</a></li>
            <li><a href="<?php echo get_post_type_archive_link('news'); ?>" class="under_line">ニュース</a></li>
            <li><a href="<?php echo home_url('/recruit'); ?>" class="under_line">採用情報</a></li>
            <li><a href="<?php echo home_url('/contact'); ?>" class="under_line">お問い合せ</a></li>
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
