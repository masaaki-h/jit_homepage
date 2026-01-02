<?php get_header(); ?>
<div style="height: 8rem;"></div>
    <div class="top_title_container">
      <div class="title_container">
        <h1>事業内容<span>Business</span></h1>
        <p>
          世界の「食」と「人」をつなぐ専門商社として、<br>
          輸入・輸出・販売促進まで一気通貫でサポートします。
        </p>
      </div>
    </div>
    <div class="business_intro_card fadein hover_three">
      <div class="business_intro_left">
        <h2>食のプロフェッショナルとして、<br>見えないところから価値を動かす。</h2>
        <p>
          JAPAN INTER TRADING は、日本と世界を結ぶ「食の架け橋」として、<br>
          商品選定・品質管理・物流・販売促進までをトータルで支援する食品商社です。
        </p>
        <p>
          大手にはない柔軟さとスピード感で、ニッチなニーズにも対応し、<br>
          パートナー企業の“黒子”として価値創造を支えます。
        </p>
        <span id="business-core"></span>
      </div>
      <div class="business_intro_right">
        <ul>
          <li><i class="fa-solid fa-check"></i> 世界各国の食品・飲料の輸入</li>
          <li><i class="fa-solid fa-check"></i> 日本発ブランドの輸出・現地展開</li>
          <li><i class="fa-solid fa-check"></i> ODM / OEM を含む商品企画・開発</li>
          <li><i class="fa-solid fa-check"></i> 売場づくり・プロモーションのサポート</li>
        </ul>
      </div>
    </div>
    
    <section class="business_card_section fadein">
      
      <div class="title_container">
        <h1>事業領域<span>Core Business</span></h1>
        <p>輸入・輸出・販売促進を軸に、ワンストップで価値を届けます。</p>
      </div>
      <div class="business_card_container">
        <div class="business_card hover_three">
          <div class="business_tag import">Import</div>
          <h3>輸入事業</h3>
          <p class="business_lead">
            欧州・アジアを中心に、世界中の魅力ある食品・飲料を日本へ。
          </p>
          <ul>
            <li>海外メーカーとの直接取引・条件交渉</li>
            <li>ODM / OEM を含む商品企画・開発支援</li>
            <li>品質・表示・法令チェック</li>
            <li>輸入通関・在庫・物流の最適化</li>
          </ul>
        </div>
        <div class="business_card hover_three">
          <div class="business_tag export">Export</div>
          <h3>輸出事業</h3>
          <p class="business_lead">
            日本製の食品・日用品を、東南アジア・北米・南米など海外市場へ。
          </p>
          <ul>
            <li>現地ニーズに合わせた商品提案</li>
            <li>ラベル・仕様のローカライズ対応</li>
            <li>海外パートナーとの共同プロモーション</li>
            <li>長期的な売場定着を見据えた取引設計</li>
          </ul>
        </div>
        <div class="business_card hover_three">
          <div class="business_tag promotion">Promotion</div>
          <h3>販売促進・サポート</h3>
          <p class="business_lead">
            「仕入れて終わり」にしない。売場づくりまで伴走する黒子の仕事。
          </p>
          <ul>
            <li>試食会・キャンペーンなど店頭プロモーション</li>
            <li>売場レイアウト・陳列提案</li>
            <li>SNS / デジタルを活用した情報発信</li>
            <li>販売データをもとにした改善提案</li>
          </ul>
        </div>
      </div>
    </section>
    <p id="business-network" style="padding-top: 3.5rem;"></p>
    <!-- Global Network -->
    <section class="global_network_section fadein" id="business-network">
      <div class="title_container">
        <h1>グローバルネットワーク<span class="globalnetwork">Global Network</span></h1>
        <p>日本を起点に、欧州・アジア・北米・南米へとネットワークを拡大しています。</p>
      </div>

      <div class="global_map_container hover_three">
        <div class="trade-map" id="tradeMap">
          <img src="<?php echo get_template_directory_uri(); ?>/img/trade.jpg" alt="世界ネットワーク" class="global_map">

          <!-- Hotspots -->
          <button class="hotspot hs-europe" data-region="europe" aria-label="ヨーロッパ"></button>
          <button class="hotspot hs-north-africa" data-region="north-africa" aria-label="北アフリカ"></button>
          <button class="hotspot hs-west-asia" data-region="west-asia" aria-label="西アジア"></button>
          <button class="hotspot hs-central-asia" data-region="central-asia" aria-label="中央アジア"></button>
          <button class="hotspot hs-se-asia" data-region="se-asia" aria-label="東南アジア"></button>
          <button class="hotspot hs-oceania" data-region="oceania" aria-label="オセアニア"></button>
          <button class="hotspot hs-north-central-america" data-region="north-central-america" aria-label="北・中央アメリカ"></button>
          <button class="hotspot hs-south-america" data-region="south-america" aria-label="南アメリカ"></button>

          <!-- Card -->
          <div class="port-card" id="portCard" aria-hidden="true">
            <button class="port-close" id="portClose" aria-label="閉じる">×</button>

            <div class="port-head">
              <p class="port-title" id="portTitle">Europe</p>
              <p class="port-sub">Trade Log</p>
            </div>

            <!-- Countries -->
            <div class="port-countries" id="portCountries"></div>

            <div class="port-cols">
              <div class="port-col">
                <p class="port-col-title">輸入商品</p>
                <ul class="port-list" id="importList"></ul>
              </div>
              <div class="port-col">
                <p class="port-col-title">輸出商品</p>
                <ul class="port-list" id="exportList"></ul>
              </div>
            </div>
          </div>

          <div class="map-backdrop" id="mapBackdrop" aria-hidden="true"></div>
        </div>
      </div>

      <p class="global_caption">※取扱国やエリアは、お取引状況に応じて随時拡大しています。</p>
    </section>
    <!-- ===== Flow ===== -->
         <!-- ===== Upstream → Downstream：食のバリューチェーン ===== -->
    <section class="business_bridge_section fadein">
       <p id="business-valuechain" style="padding-top: 4rem;"></p>
      <div class="title_container">
        <h1>バリューチェーン<span>Value Chain</span></h1>
        <p>
          「どこからどこまでお願いできるの？」というお客様にも、<br>
          生産者から生活者までの流れがひと目でイメージできるよう、JAPAN INTER TRADING が担う役割を整理しました。
        </p>
      </div>

      <div class="bridge_panel">

        <!-- ▼ 輸入フロー -->
        <div class="bridge_row">
          <div class="bridge_row_title">
            <span class="bridge_row_main">輸入（Import）</span>
            <span class="bridge_row_sub">海外から日本の食卓へ</span>
          </div>

          <div class="bridge_flow">
            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-industry"></i></div>
              <div class="bridge_node_title">海外メーカー</div>
              <div class="bridge_node_text">現地の食品・飲料・畜産メーカー</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-warehouse"></i></div>
              <div class="bridge_node_title">集荷・現地倉庫</div>
              <div class="bridge_node_text">ロットをまとめて出荷準備</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-ship"></i></div>
              <div class="bridge_node_title">国際輸送</div>
              <div class="bridge_node_text">船・飛行機で日本へ輸送</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-clipboard-check"></i></div>
              <div class="bridge_node_title">通関・検品</div>
              <div class="bridge_node_text">書類・品質・表示をチェック</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-store"></i></div>
              <div class="bridge_node_title">小売・外食・EC</div>
              <div class="bridge_node_text">店頭・オンラインで生活者へ</div>
            </div>
          </div>
        </div>

        <!-- ▼ 輸出・外国間フロー -->
        <div class="bridge_row">
          <div class="bridge_row_title">
            <span class="bridge_row_main">輸出・外国間（Export / Triangle）</span>
            <span class="bridge_row_sub">日本発ブランドや三国間にも対応</span>
          </div>

          <div class="bridge_flow">
            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-industry"></i></div>
              <div class="bridge_node_title">日本・海外のメーカー</div>
              <div class="bridge_node_text">輸出・三国間の起点となるメーカー</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-diagram-project"></i></div>
              <div class="bridge_node_title">スキーム設計</div>
              <div class="bridge_node_text">条件や通関・規制に合わせて個別設計</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-plane-departure"></i></div>
              <div class="bridge_node_title">国際輸送</div>
              <div class="bridge_node_text">現地パートナー・倉庫へ配送</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-handshake"></i></div>
              <div class="bridge_node_title">現地パートナー</div>
              <div class="bridge_node_text">卸・ディストリビューターなど</div>
            </div>

            <div class="bridge_arrow"><i class="fa-solid fa-angles-right"></i></div>

            <div class="bridge_node hover_three">
              <div class="bridge_icon"><i class="fa-solid fa-store"></i></div>
              <div class="bridge_node_title">現地の生活者</div>
              <div class="bridge_node_text">現地小売・外食・EC で展開</div>
            </div>
          </div>
        </div>

        <p class="bridge_note">
          ※ 上記は一例です。実際には、商流・物流・条件に応じてスキームを個別に設計し、<br class="pc_only">
          「どこからどこまでお願いできるか」をご相談内容に合わせて柔軟に対応いたします。
        </p>
      </div>
      <p id="business-flow"></p>
    </section>
    <section class="business_flow_section fadein">
      <div class="title_container">
        <h1>お取引の流れ<span>Flow</span></h1>
        <p>課題のヒアリングから商品提案・納品・その後のフォローまで、一貫して伴走します。</p>
      </div>

      <div class="flow_step_container">
        <div class="flow_step hover_three">
          <div class="flow_number">01</div>
          <h3>ヒアリング</h3>
          <p>ターゲット・販売チャネル・ご予算などを伺い、課題を整理します。</p>
        </div>
        <div class="flow_step hover_three">
          <div class="flow_number">02</div>
          <h3>商品・スキーム提案</h3>
          <p>輸入 / 輸出 / OEM など最適なスキームと商品構成をご提案します。</p>
        </div>
        <div class="flow_step hover_three">
          <div class="flow_number">03</div>
          <h3>条件調整・契約</h3>
          <p>数量・価格・納期・物流などの条件を詰め、契約を締結します。</p>
        </div>
        <div class="flow_step hover_three">
          <div class="flow_number">04</div>
          <h3>手配・納品</h3>
          <p>製造・輸送・通関・納品までを一括で管理し、安全にお届けします。</p>
        </div>
        <div class="flow_step hover_three">
          <div class="flow_number">05</div>
          <h3>販売フォロー</h3>
          <p>販売状況を踏まえ、追加提案やプロモーション支援を行います。</p>
        </div>
      </div>
    </section>
      <div class="business_cta_inner fadein ">
        <h2>海外展開・商品開発のパートナーをお探しの企業様へ</h2>
        <p>
          「まずは相談だけしたい」「具体的な案件について聞いてみたい」など、<br>
          小さなことでもお気軽にお問い合わせください。
        </p>
        <a href="<?php echo home_url('/contact'); ?>" class="business_cta_button">お問い合せフォームへ</a>
      </div>
<?php get_footer(); ?>