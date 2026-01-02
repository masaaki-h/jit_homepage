/* =========================================================
     Trade Map Interactive + Route Animation + Countries
     ========================================================= */
  (function setupTradeMap() {
    const map = document.getElementById("tradeMap");
    if (!map) return;

    // ▼ 地域ごとの表示データ（ここだけ編集すればOK）
    const data = {
      europe: {
        title: "ヨーロッパ",
        countries: ["フランス", "イタリア", "スペイン"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      "north-africa": {
        title: "北アフリカ",
        countries: ["モロッコ", "チュニジア", "エジプト"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      "west-asia": {
        title: "西アジア",
        countries: ["UAE", "サウジアラビア", "トルコ"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      "central-asia": {
        title: "中央アジア",
        countries: ["カザフスタン", "ウズベキスタン"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      "east-asia": {
        title: "東アジア",
        countries: ["中国", "韓国", "台湾"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      "se-asia": {
        title: "東南アジア",
        countries: ["タイ", "ベトナム", "インドネシア"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      oceania: {
        title: "オセアニア",
        countries: ["オーストラリア", "ニュージーランド"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      "north-central-america": {
        title: "北・中央アメリカ",
        countries: ["アメリカ", "メキシコ"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
      "south-america": {
        title: "南アメリカ",
        countries: ["ブラジル", "チリ", "アルゼンチン"],
        import: [{ name: "準備中", url: "#" }],
        export: [{ name: "準備中", url: "#" }],
      },
    };

    // 国名 → brand.html のアンカー（brand.htmlのidに合わせる）
    const countryAnchor = {
      フランス: "country-france",
      スペイン: "country-spain",
      イタリア: "country-italy",
      タイ: "country-thailand",
      // 追加したい国が増えたらここに足すだけ
    };

    // 航路 path id の対応（SVGを置いてるならid一致させる）
    const routeMap = {
      europe: "route-europe",
      "north-africa": "route-north-africa",
      "west-asia": "route-west-asia",
      "central-asia": "route-central-asia",
      "east-asia": "route-east-asia",
      "se-asia": "route-se-asia",
      oceania: "route-oceania",
      "north-central-america": "route-north-central-america",
      "south-america": "route-south-america",
    };

    const card = document.getElementById("portCard");
    const titleEl = document.getElementById("portTitle");
    const importList = document.getElementById("importList");
    const exportList = document.getElementById("exportList");
    const closeBtn = document.getElementById("portClose");
    const backdrop = document.getElementById("mapBackdrop");

    // ★ここが重要：business.htmlの国名領域は portCountries
    const countryWrap = document.getElementById("portCountries");

    if (!card || !titleEl || !importList || !exportList || !backdrop || !countryWrap) return;

    function setTitleWithBadge(text) {
      titleEl.textContent = text;
    }

    function renderList(el, items) {
      el.innerHTML = "";
      const valid = (items || []).filter((x) => x && x.name);

      if (valid.length === 0) {
        el.innerHTML = "<li>準備中</li>";
        return;
      }

      valid.forEach((item) => {
        const li = document.createElement("li");

        if (!item.url || item.url === "#") {
          li.textContent = item.name;
        } else {
          const a = document.createElement("a");
          a.href = item.url;
          a.textContent = item.name;
          li.appendChild(a);
        }

        el.appendChild(li);
      });
    }

    // 国名：クリックで brand.html 原産国別へ
    function renderCountries(list) {
      countryWrap.innerHTML = "";
      const valid = (list || []).filter(Boolean);
      if (valid.length === 0) return;

      valid.forEach((name) => {
        const a = document.createElement("a");
        a.className = "country-name"; // 既存CSS活かす
        a.textContent = name;

        const anchor = countryAnchor[name];
        if (anchor) {
          a.href = `brand.html?view=country#${anchor}`;
        } else {
          // アンカー未登録の国は、とりあえずbrand.htmlへ
          a.href = "brand.html";
        }

        countryWrap.appendChild(a);
      });
    }

    function clearRoutes() {
      document.querySelectorAll(".route-layer path").forEach((p) => {
        p.classList.remove("is-active");
      });
    }

    function activateRoute(region) {
      clearRoutes();
      const id = routeMap[region];
      if (!id) return;

      const path = document.getElementById(id);
      if (!path) return;

      // 連打しても毎回ちゃんと描き直す
      path.classList.remove("is-active");
      void path.getBoundingClientRect();
      path.classList.add("is-active");
    }

    function openCard(region) {
      const d = data[region] || { title: "準備中", countries: [], import: [], export: [] };

      setTitleWithBadge(d.title);
      renderCountries(d.countries);
      renderList(importList, d.import);
      renderList(exportList, d.export);

      activateRoute(region);

      card.classList.add("is-open");
      card.setAttribute("aria-hidden", "false");
      backdrop.classList.add("is-show");
      backdrop.setAttribute("aria-hidden", "false");
    }

    function closeCard() {
      card.classList.remove("is-open");
      card.setAttribute("aria-hidden", "true");
      backdrop.classList.remove("is-show");
      backdrop.setAttribute("aria-hidden", "true");
      clearRoutes();
    }

    // hotspot click
    map.querySelectorAll(".hotspot").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        const region = btn.dataset.region;
        if (!region) return;
        openCard(region);
      });
    });

    if (closeBtn) closeBtn.addEventListener("click", closeCard);
    backdrop.addEventListener("click", closeCard);

    // ESCで閉じる
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeCard();
    });
  })();