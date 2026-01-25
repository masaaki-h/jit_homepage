document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector("header");
  if (header) {
    window.addEventListener("scroll", () => {
      header.classList.toggle("scrolled", window.scrollY > 10);
    });
  }
  const fadeTargets = document.querySelectorAll(".fadein");
  if (fadeTargets.length > 0) {
    const fadeObserver = new IntersectionObserver(
      entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) entry.target.classList.add("show");
        });
      },
      { threshold: 0.2 }
    );
    fadeTargets.forEach(el => fadeObserver.observe(el));
  }
  const scrollLinks = document.querySelectorAll("a[data-scroll]");
  scrollLinks.forEach(link => {
    link.addEventListener("click", e => {
      const targetSelector = link.dataset.scroll;       
      const href = link.getAttribute("href");           
      if (!href) return;

      if (!href.startsWith("#")) return;

      e.preventDefault();

      const target = document.querySelector(targetSelector);
      if (!target) return;

      const offset = header ? header.offsetHeight + 10 : 80;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;

      window.scrollTo({ top, behavior: "smooth" });
    });
  });

  const hash = window.location.hash;
  if (hash) {
    const target = document.querySelector(hash);
    if (target) {
      const offset = header ? header.offsetHeight + 10 : 80;
      setTimeout(() => {
        const top =
          target.getBoundingClientRect().top + window.scrollY - offset;

        window.scrollTo({
          top,
          behavior: "smooth"
        });
      }, 300);
    }
  }

  $(function () {
    $(".fa-magnifying-glass").on("click", function () {
      $(".header_right_bottom input").toggle(200);
    });
  });
  $(function () {
    let menuOpen = false;
    let clickHandled = false;
    
    $(".fa-bars").on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      
      clickHandled = true;
      menuOpen = !menuOpen;
      const nav = $("nav");
      
      if (menuOpen) {
        nav.css("display", "flex");
      } else {
        nav.hide(200);
      }
      
      // 次のイベントサイクルまで待つ
      setTimeout(function() {
        clickHandled = false;
      }, 0);
      
      return false;
    });
    
    // メニュー外をクリックしたときに閉じる（ハンバーガーボタンのクリック時は無視）
    $(document).on("click", function(e) {
      if (clickHandled) {
        return;
      }
      
      if (menuOpen && !$(e.target).closest("nav, .fa-bars, .sp_header").length) {
        $("nav").hide(200);
        menuOpen = false;
      }
    });
    
    // nav内のリンクをクリックしたときに閉じる
    $("nav a").on("click", function() {
      setTimeout(function() {
        $("nav").hide(200);
        menuOpen = false;
      }, 100);
    });
  });

  // メニューリンクのクリック時にactiveクラスを追加
  const menuLinks = document.querySelectorAll(".header_left a.under_line, nav a.under_line");
  menuLinks.forEach(link => {
    link.addEventListener("click", function() {
      // 同じ親要素内の他のリンクからactiveクラスとonクラスを削除
      const parent = this.closest(".header_left") || this.closest("nav");
      if (parent) {
        const siblings = parent.querySelectorAll("a.under_line");
        siblings.forEach(sibling => {
          sibling.classList.remove("active");
          sibling.classList.remove("on");
        });
      }
      // クリックしたリンクにactiveクラスを追加
      this.classList.add("active");
      
      // スマホ表示の場合、メニューを閉じる
      if (window.innerWidth <= 768) {
        $("nav").hide(200);
      }
    });
  });

  // 現在のページURLに基づいて適切なメニュー項目にactiveクラスを付与
  const currentPath = window.location.pathname;
  const allMenuLinks = document.querySelectorAll(".header_left a.under_line, nav a.under_line");
  
  // まず全てのonクラスを削除
  allMenuLinks.forEach(link => {
    link.classList.remove("on");
  });
  
  // 現在のページに対応するリンクを探す
  allMenuLinks.forEach(link => {
    const linkUrl = link.getAttribute("href");
    if (!linkUrl) return;
    
    // リンクのパスを取得（ドメイン部分を除く）
    const linkPath = new URL(linkUrl, window.location.origin).pathname;
    
    // パスが一致するか、または現在のパスがリンクのパスを含む場合
    if (linkPath === currentPath || 
        (linkPath !== "/" && currentPath.startsWith(linkPath)) ||
        (currentPath !== "/" && linkPath.startsWith(currentPath))) {
      // 同じ親要素内の他のリンクからactiveクラスを削除
      const parent = link.closest(".header_left") || link.closest("nav");
      if (parent) {
        const siblings = parent.querySelectorAll("a.under_line");
        siblings.forEach(sibling => {
          sibling.classList.remove("active");
        });
      }
      // 現在のページに対応するリンクにactiveクラスを追加
      link.classList.add("active");
    }
  });

  // 言語切り替えボタンの処理
  const langButtons = document.querySelectorAll(".header_right_top button");
  
  function triggerTranslation(lang) {
    // 複数の方法を試す
    const select = document.querySelector(".goog-te-combo");
    if (select) {
      select.value = lang;
      // 複数のイベントを発火
      select.dispatchEvent(new Event("change", { bubbles: true }));
      select.dispatchEvent(new Event("input", { bubbles: true }));
      // Google翻訳の内部関数を直接呼び出す
      if (window.google && window.google.translate && window.google.translate.TranslateElement) {
        try {
          const frame = document.querySelector(".goog-te-banner-frame");
          if (frame && frame.contentWindow) {
            frame.contentWindow.postMessage({ type: "translate", lang: lang }, "*");
          }
        } catch(e) {
          console.log("Translation trigger attempt:", e);
        }
      }
      return true;
    }
    return false;
  }
  
  function waitForGoogleTranslate(callback, maxAttempts = 20) {
    let attempts = 0;
    const checkInterval = setInterval(() => {
      attempts++;
      if (triggerTranslation("en") || attempts >= maxAttempts) {
        clearInterval(checkInterval);
        const select = document.querySelector(".goog-te-combo");
        callback(select);
      }
    }, 200);
  }
  
  langButtons.forEach(button => {
    button.addEventListener("click", function(e) {
      e.preventDefault();
      const buttonText = this.textContent.trim();
      
      if (buttonText === "English") {
        if (triggerTranslation("en")) {
          // 成功
          return;
        }
        // ウィジェットがまだ読み込まれていない場合、待機
        waitForGoogleTranslate((select) => {
          if (!select) {
            // 最終的に読み込まれなかった場合
            setTimeout(() => {
              if (!triggerTranslation("en")) {
                alert("翻訳機能の読み込みに時間がかかっています。ページを再読み込みしてから再度お試しください。");
              }
            }, 1000);
          }
        });
      } else if (buttonText === "日本語") {
        if (triggerTranslation("ja")) {
          // 成功
          return;
        }
        // ウィジェットがまだ読み込まれていない場合、待機
        setTimeout(() => {
          if (!triggerTranslation("ja")) {
            window.location.reload();
          }
        }, 500);
      }
    });
  });
  
});