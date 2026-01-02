<?php get_header(); ?>
<?php
// お問い合わせページのURL
$contact_url = get_permalink(get_page_by_path('contact'));
if (!$contact_url) {
  $contact_url = home_url('/contact');
}
?>
    <section class="top_title_container">
      <div class="title_container">
        <h1>お問い合せ<span>Contact</span></h1>
        <p>お問い合せありがとうございます。</p>
      </div>
    </section>

    <main class="news_detail_section fadein">
      <div class="news_detail_inner">

        <div class="news_breadcrumb">
          <a href="<?php echo esc_url(home_url()); ?>">ホーム</a> / <a href="<?php echo esc_url($contact_url); ?>">お問い合せ</a> / 送信完了
        </div>

        <div class="news_detail_meta">
          <span class="news_date"><?php echo esc_html(date('Y.m.d')); ?></span>
        </div>

        <h2 class="news_detail_title">お問い合せありがとうございました</h2>

        <div class="news_detail_lead">
          お問い合せ内容を送信いたしました。<br>
          担当者より、3営業日以内にご連絡させていただきます。<br>
          今しばらくお待ちください。
        </div>

        <article class="news_detail_body">
          <p>ご入力いただいたメールアドレスに、自動返信メールをお送りしております。<br>
          メールが届かない場合は、お手数ですが下記の連絡先までご連絡ください。</p>

          <h3>お問い合せ先</h3>
          <p>
            <strong>電話：</strong><a href="tel:0362816410">03-6281-6410</a><br>
            <strong>メール：</strong><a href="mailto:info@example.com">info@example.com</a><br>
            <strong>受付時間：</strong>平日 9:00〜18:00（土日祝・年末年始を除く）
          </p>
        </article>

        <section class="news_detail_cta hover_three">
          <h3>その他のお問い合せ</h3>
          <p>追加でご質問がございましたら、お気軽にご連絡ください。</p>
          <a class="news_cta_button" href="<?php echo esc_url($contact_url); ?>">お問い合せフォームへ</a>
        </section>

        <div class="news_detail_back">
          <a href="<?php echo esc_url(home_url()); ?>" class="hover_two">← トップページへ戻る</a>
        </div>

      </div>
    </main>
<?php get_footer(); ?>

