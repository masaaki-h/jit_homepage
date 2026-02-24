<?php get_header(); ?>
    <div style="height: 8rem;"></div>
    <section class="top_title_container">
      <div class="title_container">
        <h1>お問い合せ<span>Contact</span></h1>
        <p>
          お取引や商品に関するご相談、採用に関するご質問など、<br>
          下記フォームまたはお電話にてお気軽にお問い合せください。
        </p>
      </div>
    </section>
    <section class="contact_form_section fadein">
      <div class="contact_form_inner">
        <h2>お問い合せフォーム</h2>
        <form action="https://webto.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8&orgId=00DGB000003a5W2" method="POST" class="contact_form">
          <input type="hidden" name="oid" value="00DGB000003a5W2">
          <?php
            // サンクスページのURL
            $thanks_url = get_permalink(get_page_by_path('thanks'));
            if (!$thanks_url) {
              $thanks_url = home_url('/thanks');
            }
          ?>
          <input type="hidden" name="retURL" value="<?php echo esc_url($thanks_url); ?>">

          <div class="form_row form_row_half">
            <div class="form_col">
              <label for="last_name">姓<span class="required">必須</span></label>
              <input type="text" id="last_name" name="last_name" maxlength="80" size="20" required>
            </div>
            <div class="form_col">
              <label for="first_name">名<span class="required">必須</span></label>
              <input type="text" id="first_name" name="first_name" maxlength="40" size="20" required>
            </div>
          </div>
          <div class="form_row">
            <label for="company">会社名</label>
            <input type="text" id="company" name="company" maxlength="40" size="20">
          </div>
          <div class="form_row form_row_half">
            <div class="form_col">
              <label for="email">メールアドレス<span class="required">必須</span></label>
              <input type="email" id="email" name="email" maxlength="80" size="20" required>
            </div>
            <div class="form_col">
              <label for="phone">電話番号</label>
              <input type="tel" id="phone" name="phone" maxlength="40" size="20" placeholder="例）03-0000-0000">
            </div>
          </div>
          <div class="form_row">
            <label for="country">国</label>
            <input type="text" id="country" name="country" maxlength="40" size="20" value="日本">
          </div>
          <div class="form_row form_row_half">
            <div class="form_col">
              <label for="zip">郵便番号</label>
              <input type="text" id="zip" name="zip" maxlength="20" size="20" placeholder="例）100-0001">
            </div>
            <div class="form_col">
              <label for="state">都道府県</label>
              <input type="text" id="state" name="state" maxlength="20" size="20">
            </div>
          </div>
          <div class="form_row">
            <label for="city">市区郡</label>
            <input type="text" id="city" name="city" maxlength="40" size="20">
          </div>
          <div class="form_row">
            <label for="street">町名・番地</label>
            <textarea id="street" name="street" rows="1"></textarea>
          </div>
          <div class="form_row">
            <label for="00NfS0000051BJV">お問い合わせ種別<span class="required">必須</span></label>
            <select id="00NfS0000051BJV" name="00NfS0000051BJV" title="お問い合わせ種別" required>
              <option value="">選択してください</option>
              <option value="import">商品・仕入れに関するご相談（輸入）</option>
              <option value="export">日本製品の海外展開に関するご相談（輸出）</option>
              <option value="odm">ODM・OEM に関するご相談</option>
              <option value="recruitment">採用に関するお問い合せ</option>
              <option value="other">その他のお問い合せ</option>
            </select>
          </div>
          <div class="form_row">
            <label for="00NfS00000512pj">お問い合せ内容<span class="required">必須</span></label>
            <textarea id="00NfS00000512pj" name="00NfS00000512pj" rows="6" wrap="soft" required></textarea>
          </div>
          <div class="form_row form_row_checkbox">
            <label>
              <input type="checkbox" name="agree" required>
              <span>個人情報の取り扱いに同意します。</span>
            </label>
            <p class="privacy_note">
              お預かりした個人情報は、お問い合せへのご回答のみに利用し、<br>
              当社のプライバシーポリシーに基づき適切に管理いたします。
            </p>
          </div>
          <div class="form_row form_row_submit">
            <button type="submit" class="contact_submit_button">送信する</button>
          </div>
        </form>
      </div>
    </section>
    <section class="contact_info_section fadein">
      <div class="contact_info_inner">
        <div class="contact_info_box">
          <h3>お電話でのお問い合せ</h3>
          <p class="contact_tel">TEL: <a href="tel:0362816410">03-6281-6410</a></p>
          <p class="contact_time">受付時間 : 平日 9:00〜18:00（土日祝・年末年始を除く）</p>
        </div>
      </div>
    </section>
<?php get_footer(); ?>