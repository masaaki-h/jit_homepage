<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>JAPAN INTER TRADING</title> 
        <meta name="description" content="JAPAN INTER TRADING公式サイト。食品を通じて人と価値を繋ぐ架け橋となる総合商社。">
        <meta name="keywords" content="食品商社, 総合商社, JAPAN INTER TRADING, 10周年, 食品輸出, 食品輸入">
        
        <!-- Google翻訳 -->
        <div id="google_translate_element" style="position: absolute; top: -9999px; left: -9999px;"></div>
        <script type="text/javascript">
          function googleTranslateElementInit() {
            if (typeof google !== "undefined" && google.translate) {
              new google.translate.TranslateElement({
                pageLanguage: 'ja',
                includedLanguages: 'ja,en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
              }, 'google_translate_element');
            }
          }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

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
                        <button>日本語</button>
                        <button>English</button>
                        <span>|</span>
                        <button><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <div class="header_right_bottom">
                        <input type="text" placeholder="キーワードを入力">
                    </div>
                </div>
            </div>
            <div class="sp_header pc_none">
                <a href="index.html"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.webp"></a>
                <a href="index.html" class="bold">JAPAN INTER TRADING</a>
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