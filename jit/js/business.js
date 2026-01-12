/* =========================================================
     Trade Map Interactive + Route Animation
     ========================================================= */
(function setupTradeMap() {
  const map = document.getElementById("tradeMap");
  if (!map) return;

  // =========================================================
  // データ定義
  // =========================================================
  const JAPAN_POSITION = { left: 40.7, top: 41 };

  const AREA_DATA = {
    europe: {
      title: "ヨーロッパ",
      titleEn: "Europe",
      position: { left: 10, top: 29.65 },
      countries: [
        { name: "フランス", slug: "france" },
        { name: "イタリア", slug: "italy" },
        { name: "スペイン", slug: "spain" },
      ],
      import: [{ name: "準備中", url: "#" }],
      export: [{ name: "準備中", url: "#" }],
    },
    "central-asia": {
      title: "中央アジア",
      titleEn: "Central Asia",
      position: { left: 23, top: 38 },
      countries: [
        { name: "UAE", slug: "uae" },
      ],
      import: [{ name: "準備中", url: "#" }],
      export: [{ name: "準備中", url: "#" }],
    },
    "east-asia": {
      title: "東アジア",
      titleEn: "East Asia",
      position: { left: 34, top: 41 },
      countries: [
        { name: "中国", slug: "china" },
        { name: "韓国", slug: "south-korea" },
      ],
      import: [{ name: "準備中", url: "#" }],
      export: [{ name: "準備中", url: "#" }],
    },
    "se-asia": {
      title: "東南アジア",
      titleEn: "Southeast Asia",
      position: { left: 36, top: 57.5618 },
      countries: [
        { name: "タイ", slug: "thailand" },
      ],
      import: [{ name: "準備中", url: "#" }],
      export: [{ name: "準備中", url: "#" }],
    },
    "north-central-america": {
      title: "北米・中央アメリカ",
      titleEn: "North & Central America",
      position: { left: 80, top: 36 },
      countries: [
        { name: "アメリカ", slug: "usa" },
        { name: "カナダ", slug: "canada" },
        { name: "メキシコ", slug: "mexico" },
      ],
      import: [{ name: "準備中", url: "#" }],
      export: [{ name: "準備中", url: "#" }],
    },
    "south-america": {
      title: "南アメリカ",
      titleEn: "South America",
      position: { left: 93, top: 63 },
      countries: [
        { name: "ブラジル", slug: "brazil" },
        { name: "アルゼンチン", slug: "argentina" },
        { name: "チリ", slug: "chile" },
      ],
      import: [{ name: "準備中", url: "#" }],
      export: [{ name: "準備中", url: "#" }],
    },
  };

  // =========================================================
  // DOM要素の取得
  // =========================================================
  const card = document.getElementById("portCard");
  const titleEl = document.getElementById("portTitle");
  const importList = document.getElementById("importList");
  const exportList = document.getElementById("exportList");
  const closeBtn = document.getElementById("portClose");
  const backdrop = document.getElementById("mapBackdrop");
  const countryWrap = document.getElementById("portCountries");

  if (!card || !titleEl || !importList || !exportList || !backdrop || !countryWrap) return;

  // =========================================================
  // 状態管理
  // =========================================================
  const state = {
    currentLine: null,      // 現在表示中のライン
    hoveredLine: null,     // マウスオーバー中のライン（仮ターゲット）
    fixedLine: null,       // クリックで固定されたライン
    activeHotspot: null,    // 現在選択中のhotspot
    areaLines: new Map(),  // エリアキー → ライン要素のマップ
  };

  // =========================================================
  // ユーティリティ関数
  // =========================================================
  function setTitle(text) {
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

  function renderCountries(countries) {
    countryWrap.innerHTML = "";
    const valid = (countries || []).filter(Boolean);
    if (valid.length === 0) return;

    valid.forEach((country) => {
      const name = typeof country === 'string' ? country : country.name;
      const a = document.createElement("a");
      a.className = "country-name";
      a.textContent = name;

      if (typeof country === 'object' && country.slug) {
        a.href = `/wordpress/products/?view=country#country-${country.slug}`;
      } else {
        a.href = "/wordpress/products/";
      }

      countryWrap.appendChild(a);
    });
  }

  // =========================================================
  // ライン描画
  // =========================================================
  function createLine(fromPercent, toPercent, svg) {
    const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    
    svg.setAttribute("viewBox", "0 0 100 100");
    svg.setAttribute("preserveAspectRatio", "none");
    
    const dx = toPercent.left - fromPercent.left;
    const dy = toPercent.top - fromPercent.top;
    const distance = Math.sqrt(dx * dx + dy * dy);
    
    // アーチの頂点を計算
    const midX = (fromPercent.left + toPercent.left) / 2;
    const midY = (fromPercent.top + toPercent.top) / 2;
    const archHeight = Math.min(distance * 0.2, 10);
    const peakY = midY - archHeight;
    
    // ベジェ曲線のコントロールポイント
    const controlX1 = midX - dx * 0.1;
    const controlY1 = peakY;
    const controlX2 = midX + dx * 0.1;
    const controlY2 = peakY;
    
    const pathData = `M ${fromPercent.left} ${fromPercent.top} C ${controlX1} ${controlY1}, ${controlX2} ${controlY2}, ${toPercent.left} ${toPercent.top}`;
    
    path.setAttribute("d", pathData);
    path.setAttribute("class", "route-line");
    path.setAttribute("stroke", "rgba(196, 170, 110, 0.6)");
    path.setAttribute("stroke-width", "0.3");
    path.setAttribute("fill", "none");
    path.setAttribute("stroke-dasharray", "1,1");
    path.style.opacity = "0";
    path.style.transition = "opacity 0.3s ease";
    
    svg.appendChild(path);
    return path;
  }

  function animateLine(line) {
    const pathLength = line.getTotalLength();
    
    line.style.transition = "none";
    line.style.strokeDasharray = `${pathLength} ${pathLength}`;
    line.style.strokeDashoffset = pathLength;
    line.style.opacity = "1";
    
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        line.style.transition = "stroke-dashoffset 0.8s ease-out";
        line.style.strokeDashoffset = "0";
      });
    });
  }

  function hideLine(line) {
    if (!line) return;
    line.style.opacity = "0";
    line.style.strokeDashoffset = line.getTotalLength();
  }

  function showLine(line, skipAnimation = false) {
    if (!line) return;
    
    if (skipAnimation) {
      line.style.opacity = "1";
      line.style.strokeDashoffset = "0";
      line.style.transition = "none";
    } else {
      animateLine(line);
    }
  }

  // =========================================================
  // パネル管理
  // =========================================================
  function openCard(areaKey) {
    const areaData = AREA_DATA[areaKey];
    if (!areaData) return;

    // エリアデータを準備
    const countries = Array.isArray(areaData.countries)
      ? areaData.countries
      : [];

    const cardData = {
      title: areaData.title,
      countries: countries,
      import: areaData.import || [],
      export: areaData.export || [],
    };

    // ラインを表示
    const line = state.areaLines.get(areaKey);
    if (line) {
      const isAlreadyVisible = (state.hoveredLine === line || state.currentLine === line) &&
                               line.style.opacity === "1" &&
                               parseFloat(line.style.strokeDashoffset || line.getTotalLength()) < line.getTotalLength() * 0.1;

      state.fixedLine = line;
      state.hoveredLine = null;

      if (state.currentLine && state.currentLine !== line) {
        hideLine(state.currentLine);
      }

      state.currentLine = line;
      showLine(line, isAlreadyVisible);
    }

    // パネルの内容を更新
    const isAlreadyOpen = card.classList.contains("is-open");

    if (isAlreadyOpen) {
      card.style.transition = "opacity 0.15s ease";
      card.style.opacity = "0";
      
      setTimeout(() => {
        updateCardContent(cardData);
        requestAnimationFrame(() => {
          card.style.transition = "opacity 0.25s ease";
          card.style.opacity = "1";
        });
      }, 150);
    } else {
      updateCardContent(cardData);
      card.classList.add("is-open");
      card.setAttribute("aria-hidden", "false");
      backdrop.classList.add("is-show");
      backdrop.setAttribute("aria-hidden", "false");
      
      card.style.opacity = "0";
      card.style.transition = "opacity 0.25s ease";
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          card.style.opacity = "1";
        });
      });
    }

    // hotspotをハイライト
    if (state.activeHotspot) {
      state.activeHotspot.classList.remove("is-active");
    }
    const hotspot = map.querySelector(`.hotspot[data-area="${areaKey}"]`);
    if (hotspot) {
      hotspot.classList.add("is-active");
      state.activeHotspot = hotspot;
    }
  }

  function updateCardContent(cardData) {
    setTitle(cardData.title);
    renderCountries(cardData.countries);
    renderList(importList, cardData.import);
    renderList(exportList, cardData.export);
  }

  function closeCard() {
    card.style.transition = "opacity 0.2s ease";
    card.style.opacity = "0";
    
    setTimeout(() => {
      card.classList.remove("is-open");
      card.setAttribute("aria-hidden", "true");
      backdrop.classList.remove("is-show");
      backdrop.setAttribute("aria-hidden", "true");
      
      hideLine(state.currentLine);
      state.currentLine = null;
      state.fixedLine = null;
      state.hoveredLine = null;
      
      if (state.activeHotspot) {
        state.activeHotspot.classList.remove("is-active");
        state.activeHotspot = null;
      }
    }, 200);
  }

  // =========================================================
  // Hotspot生成
  // =========================================================
  function createJapanHotspot() {
    const btn = document.createElement("button");
    btn.className = "hotspot hotspot-japan";
    btn.style.left = `${JAPAN_POSITION.left}%`;
    btn.style.top = `${JAPAN_POSITION.top}%`;
    btn.setAttribute("aria-label", "日本");
    btn.setAttribute("data-area", "japan");
    return btn;
  }

  function createAreaHotspot(areaKey, areaData) {
    const btn = document.createElement("button");
    btn.className = "hotspot hotspot-country";
    btn.style.left = `${areaData.position.left}%`;
    btn.style.top = `${areaData.position.top}%`;
    btn.setAttribute("aria-label", areaData.title);
    btn.setAttribute("data-area", areaKey);
    
    // エリア名を表示（日本語と英語）
    const nameContainer = document.createElement("span");
    nameContainer.className = "country-name-label";
    
    const nameJa = document.createElement("span");
    nameJa.className = "country-name-ja";
    nameJa.textContent = areaData.title;
    nameContainer.appendChild(nameJa);
    
    if (areaData.titleEn) {
      const nameEn = document.createElement("span");
      nameEn.className = "country-name-en";
      nameEn.textContent = areaData.titleEn;
      nameContainer.appendChild(nameEn);
    }
    
    btn.appendChild(nameContainer);

    return btn;
  }

  function setupHotspotEvents(hotspot, areaKey, line) {
    // マウスオーバー
    hotspot.addEventListener("mouseenter", () => {
      if (state.fixedLine) return;
      if (state.hoveredLine === line && line.style.opacity === "1") return;

      if (state.hoveredLine && state.hoveredLine !== line) {
        hideLine(state.hoveredLine);
      }

      state.hoveredLine = line;
      state.currentLine = line;
      animateLine(line);
    });

    // マウスリーブ
    hotspot.addEventListener("mouseleave", () => {
      if (state.fixedLine) return;
      if (state.hoveredLine === line) {
        hideLine(line);
        state.hoveredLine = null;
        state.currentLine = null;
      }
    });

    // クリック
    hotspot.addEventListener("click", (e) => {
      e.preventDefault();
      openCard(areaKey);
    });
  }

  // =========================================================
  // 初期化
  // =========================================================
  function init() {
    // SVGコンテナを作成
    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("class", "route-layer");
    svg.setAttribute("viewBox", "0 0 100 100");
    svg.setAttribute("preserveAspectRatio", "none");
    svg.style.position = "absolute";
    svg.style.top = "0";
    svg.style.left = "0";
    svg.style.width = "100%";
    svg.style.height = "100%";
    svg.style.pointerEvents = "none";
    svg.style.zIndex = "1";
    map.appendChild(svg);

    // 日本のhotspot
    const japanHotspot = createJapanHotspot();
    map.appendChild(japanHotspot);

    // 各エリアのhotspotを生成
    Object.entries(AREA_DATA).forEach(([areaKey, areaData]) => {
      if (!areaData.position) return;

      const hotspot = createAreaHotspot(areaKey, areaData);
      const line = createLine(JAPAN_POSITION, areaData.position, svg);
      line.setAttribute("data-area", areaKey);
      state.areaLines.set(areaKey, line);

      setupHotspotEvents(hotspot, areaKey, line);
      map.appendChild(hotspot);
    });

    // イベントリスナー
    if (closeBtn) closeBtn.addEventListener("click", closeCard);
    backdrop.addEventListener("click", closeCard);

    const globalMapImg = map.querySelector(".global_map");
    if (globalMapImg) {
      globalMapImg.addEventListener("click", (e) => {
        const clickedElement = e.target;
        const isMapImage = clickedElement === globalMapImg || clickedElement.classList.contains("global_map");
        
        if (isMapImage) {
          const isFromHotspot = e.target.closest && e.target.closest(".hotspot");
          const isFromCard = e.target.closest && e.target.closest(".port-card");
          const isFromBackdrop = e.target.closest && e.target.closest(".map-backdrop");
          const isFromRoute = e.target.closest && e.target.closest(".route-layer");
          
          if (!isFromHotspot && !isFromCard && !isFromBackdrop && !isFromRoute) {
            e.stopPropagation();
            e.preventDefault();
            closeCard();
            return false;
          }
        }
      }, true);
    }

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeCard();
    });
  }

  // 実行
  init();
})();
