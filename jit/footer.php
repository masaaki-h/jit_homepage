<footer class="fadein">
            <div class="footer_top_container">
                <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png">
                <h3>JAPAN INTER TRADING 株式会社</h3>
                <p>〒103-0022 東京都中央区日本橋室町１丁目２−６<span>TEL: <a href="tel:0362816410">03-6281-6410</a></span></p>
            </div>
            <div class="footer_bottom_container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.6895088993983!2d139.7738574!3d35.6846465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6018f2d52b8eaf71%3A0x1e047b7a7e270295!2z44K444Oj44OR44Oz772l44Kk44Oz44K_44O844OI44Os44O844OH44Kj44Oz44Kw44ix!5e0!3m2!1sja!2sjp!4v1762247644899!5m2!1sja!2sjp" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
             <div class="footer_list">
            <ul>
                <li><a href="<?php echo home_url('/company'); ?>">会社概要</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/company'); ?>#company-philosophy" data-scroll="#company-philosophy">経営理念</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/company'); ?>#company-history" data-scroll="#company-history">歴史・沿革</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/company'); ?>#company-message" data-scroll="#company-message">社長メッセージ</a></li>
                <li class="sp_none">　</li>
            </ul>
            <ul>
                <li><a href="<?php echo home_url('/business'); ?>">事業内容</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/business'); ?>#business-core" data-scroll="#business-core">事業領域</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/business'); ?>#business-network" data-scroll="#business-network">グローバルネットワーク</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/business'); ?>#business-valuechain" data-scroll="#business-valuechain">バリューチェーン</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/business'); ?>#business-flow" data-scroll="#business-flow">お取引の流れ</a></li>
            </ul>
            <ul>
                <li><a href="<?php echo get_post_type_archive_link('product'); ?>">商品一覧</a></li>
                <li class="sp_none"><a href="<?php echo get_post_type_archive_link('product'); ?>#brand-category">カテゴリ別</a></li>
                <li class="sp_none"><a href="<?php echo get_post_type_archive_link('product'); ?>#brand-country">原産国別</a></li>
                <li class="sp_none"><a href="<?php echo get_post_type_archive_link('product'); ?>#brand-list">ブランド別</a></li>
                <li class="sp_none">　</li>
            </ul>
            <ul>
                <li><a href="<?php echo get_post_type_archive_link('news'); ?>">ニュース</a></li>
                <li class="sp_none"><a href="<?php echo add_query_arg('nc', 'info', get_post_type_archive_link('news')); ?>">お知らせ</a></li>
                <li class="sp_none"><a href="<?php echo add_query_arg('nc', 'press', get_post_type_archive_link('news')); ?>">プレスリリース</a></li>
                <li class="sp_none"><a href="<?php echo add_query_arg('nc', 'recruit', get_post_type_archive_link('news')); ?>">採用情報</a></li>
                 <li class="sp_none">　</li>
            </ul>
            <ul>
                <li><a href="<?php echo home_url('/recruit'); ?>">採用情報</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/recruit'); ?>#recruit-positions" data-scroll="#recruit-positions">募集ポジション</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/recruit'); ?>#recruit-requirements" data-scroll="#recruit-requirements">募集要項</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/recruit'); ?>#recruit-flow" data-scroll="#recruit-flow">選考フロー</a></li>
                <li class="sp_none">　</li>

            </ul>
            <ul>
                <li><a href="<?php echo home_url('/contact'); ?>">お問い合せ</a></li>
                <li class="sp_none"><a href="<?php echo home_url('/contact'); ?>">お問合せフォーム</a></li>
                <li class="sp_none">　</li>
                <li class="sp_none">　</li>
                <li class="sp_none">　</li>
            </ul>
        </div>
        <div class="copy"><p>Copyright © 2022 JAPAN INTER TRADING CO., LTD. All Rights Reserved.</p></div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <?php if (is_post_type_archive('product')) : ?>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
            const tabButtons = document.querySelectorAll(".brand-tab-button");
            const views = {
                category: document.getElementById("brand-category"),
                country: document.getElementById("brand-country"),
                brand:    document.getElementById("brand-list"),
            };

            function activate(viewName) {
                tabButtons.forEach(b => {
                b.classList.toggle("is-active", b.dataset.view === viewName);
                });
                Object.keys(views).forEach(key => {
                if (!views[key]) return;
                views[key].classList.toggle("is-active", key === viewName);
                });
            }

            tabButtons.forEach(button => {
                button.addEventListener("click", () => {
                const target = button.dataset.view;
                activate(target);
                });
            });

            const hash = window.location.hash;
            if (hash === "#brand-country") {
                activate("country");
            } else if (hash === "#brand-list") {
                activate("brand");
            } else {
                activate("category");
            }
            });
        </script>
        <?php endif; ?>

        <?php if (is_page('news')) : ?>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            /* ==============================
            News フィルター機能
            .news_filter_tabs と .news_item を連動
            ============================== */
            const tabs  = document.querySelectorAll(".news_filter_tabs li");
            const items = document.querySelectorAll(".news_list .news_item");

            if (!tabs.length || !items.length) return;

            // タブの文字からカテゴリキーを決める
            const getCategoryFromTab = (tab) => {
            const text = tab.textContent.trim();
            if (text === "すべて")       return "all";
            if (text === "お知らせ")     return "info";
            if (text === "プレスリリース") return "press";
            if (text === "採用情報")     return "recruit";
            return "all";
            };

            tabs.forEach(tab => {
            tab.addEventListener("click", () => {
                const category = getCategoryFromTab(tab);

                // タブの見た目更新
                tabs.forEach(t => t.classList.remove("active"));
                tab.classList.add("active");

                // ニュースの表示切り替え
                items.forEach(item => {
                const catLabel = item.querySelector(".news_cat");

                // Coming soon のボックスは「すべて」のときだけ表示
                if (item.classList.contains("news_item_coming")) {
                    item.style.display = (category === "all") ? "" : "none";
                    return;
                }

                if (!catLabel) {
                    item.style.display = "none";
                    return;
                }

                if (category === "all") {
                    item.style.display = "";
                    return;
                }

                const match = catLabel.classList.contains(`cat-${category}`);
                item.style.display = match ? "" : "none";
                });
            });
            });
        });
        </script>
        <?php endif; ?>

        <?php if (is_page('business')) : ?>
        <script src="<?php echo get_template_directory_uri(); ?>/js/business.js" defer></script>
        <?php endif; ?>

        <script src="<?php echo get_template_directory_uri(); ?>/js/common.js" defer></script>
        <?php wp_footer(); ?>
    </body>
</html>