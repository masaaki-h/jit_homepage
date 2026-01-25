/* =========================================================
     Trade Map Interactive + Route Animation
     ========================================================= */
(function setupTradeMap() {
  const map = document.getElementById("tradeMap");
  if (!map) return;

  // =========================================================
  // 定数定義
  // =========================================================
  const JAPAN_POSITION = { left: 40.7, top: 41 };
  const ICON_SIZE = 5.5;
  const ANIMATION_DURATION = {
    LINE: { RIGHT: 1200, LEFT: 800 },
    ICON: { RIGHT: 1800, LEFT: 1200 },
  };
  const ICON_ROTATION = {
    RIGHT_SIDE_OFFSET: 90,
    PLANE_LEFT_OFFSET: 85,
  };
  const ICON_SVG = {
    SHIP: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23c4aa6e'%3E%3Cpath d='M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.38 0 2.74-.35 4-.99 2.52 1.29 5.48 1.29 8 0 1.26.65 2.62.99 4 .99h2v-2h-2zM3.95 19H4c1.6 0 3.02-.88 4-2 .98 1.12 2.4 2 4 2s3.02-.88 4-2c.98 1.12 2.4 2 4 2h.05l2.18-7.65-2.23-.73V4h-5V1H9v3H4v6.62l-2.23.73L3.95 19zM6 6h12v6.78l-12-3.9V6z'/%3E%3C/svg%3E",
    PLANE: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23c4aa6e'%3E%3Cpath d='M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z'/%3E%3C/svg%3E",
  };

  const AREA_DATA = {
    europe: {
      title: "ヨーロッパ",
      titleEn: "Europe",
      position: { left: 10, top: 29.65 },
      iconType: "plane",
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
      iconType: "plane",
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
      iconType: "ship",
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
      iconType: "ship",
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
      iconType: "plane",
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
      iconType: "plane",
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
    currentLine: null,
    hoveredLine: null,
    fixedLine: null,
    activeHotspot: null,
    areaLines: new Map(),
    lineIcons: new Map(),
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
  // アイコン関連関数
  // =========================================================
  function createIcon(svg, iconType) {
    const icon = document.createElementNS("http://www.w3.org/2000/svg", "image");
    icon.setAttribute("width", ICON_SIZE);
    icon.setAttribute("height", ICON_SIZE);
    icon.setAttribute("opacity", "0");
    icon.style.transition = "opacity 0.3s ease";
    
    const iconHref = iconType === "ship" ? ICON_SVG.SHIP : ICON_SVG.PLANE;
    icon.setAttribute("href", iconHref);
    
    svg.appendChild(icon);
    return icon;
  }

  function calculateIconAngle(startPoint, endPoint, isRightSide, iconType) {
    let angle = Math.atan2(endPoint.y - startPoint.y, endPoint.x - startPoint.x) * (180 / Math.PI);
    
    if (isRightSide) {
      angle += ICON_ROTATION.RIGHT_SIDE_OFFSET;
    } else if (iconType === "plane") {
      angle -= ICON_ROTATION.PLANE_LEFT_OFFSET;
    }
    
    return angle;
  }

  function applyIconTransform(icon, angle, centerX, centerY, isRightSide, iconType) {
    if (isRightSide) {
      icon.setAttribute("transform", `rotate(${angle} ${centerX} ${centerY})`);
    } else {
      icon.setAttribute(
        "transform",
        `translate(${centerX} ${centerY}) rotate(${angle}) scale(1, -1) translate(${-centerX} ${-centerY})`
      );
    }
  }

  function setIconPosition(icon, point, iconSize = ICON_SIZE) {
    icon.setAttribute("x", point.x - iconSize / 2);
    icon.setAttribute("y", point.y - iconSize / 2);
  }

  // =========================================================
  // ライン描画
  // =========================================================
  function createLine(fromPercent, toPercent, svg, areaKey) {
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
    
    // 太いパス（外側）
    const pathThick = document.createElementNS("http://www.w3.org/2000/svg", "path");
    pathThick.setAttribute("d", pathData);
    pathThick.setAttribute("class", "route-line route-line-thick");
    pathThick.setAttribute("stroke", "rgba(196, 170, 110, 0.4)");
    pathThick.setAttribute("stroke-width", "0.5");
    pathThick.setAttribute("fill", "none");
    pathThick.setAttribute("stroke-dasharray", "1,1");
    pathThick.style.opacity = "0";
    pathThick.style.transition = "opacity 0.3s ease";
    pathThick.setAttribute("data-area", areaKey);
    
    // 細いパス（内側）
    const pathThin = document.createElementNS("http://www.w3.org/2000/svg", "path");
    pathThin.setAttribute("d", pathData);
    pathThin.setAttribute("class", "route-line route-line-thin");
    pathThin.setAttribute("stroke", "rgba(196, 170, 110, 0.6)");
    pathThin.setAttribute("stroke-width", "0.15");
    pathThin.setAttribute("fill", "none");
    pathThin.setAttribute("stroke-dasharray", "1,1");
    pathThin.style.opacity = "0";
    pathThin.style.transition = "opacity 0.3s ease";
    pathThin.setAttribute("data-area", areaKey);
    
    // コンテナグループを作成
    const group = document.createElementNS("http://www.w3.org/2000/svg", "g");
    group.setAttribute("class", "route-line-group");
    group.setAttribute("data-area", areaKey);
    group.appendChild(pathThick);
    group.appendChild(pathThin);
    
    svg.appendChild(group);
    
    return pathThin;
  }

  function setupLineAnimation(pathThick, pathThin, pathLength, lineDuration) {
    [pathThick, pathThin].forEach(path => {
      path.style.transition = "none";
      path.style.strokeDasharray = `${pathLength} ${pathLength}`;
      path.style.strokeDashoffset = pathLength;
      path.style.opacity = "1";
    });

    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        [pathThick, pathThin].forEach(path => {
          path.style.transition = `stroke-dashoffset ${lineDuration}ms ease-out`;
          path.style.strokeDashoffset = "0";
        });
      });
    });
  }

  function easeOut(t) {
    return 1 - Math.pow(1 - t, 3);
  }

  function animateIcon(icon, line, pathLength, iconDuration, isRightSide, iconType) {
    const startPoint = line.getPointAtLength(0);
    const endPoint = line.getPointAtLength(pathLength);
    
    // 初期位置と角度を設定
    setIconPosition(icon, startPoint);
    const initialAngle = calculateIconAngle(startPoint, endPoint, isRightSide, iconType);
    applyIconTransform(icon, initialAngle, startPoint.x, startPoint.y, isRightSide, iconType);
    
    icon.style.opacity = "1";
    const startTime = Date.now();
    
    function updateIcon() {
      const elapsed = Date.now() - startTime;
      const linearProgress = Math.min(elapsed / iconDuration, 1);
      const progress = easeOut(linearProgress);
      
      if (linearProgress < 1) {
        const point = line.getPointAtLength(pathLength * progress);
        setIconPosition(icon, point);
        
        if (progress > 0.01) {
          const prevPoint = line.getPointAtLength(pathLength * (progress - 0.01));
          const angle = calculateIconAngle(prevPoint, point, isRightSide, iconType);
          applyIconTransform(icon, angle, point.x, point.y, isRightSide, iconType);
        }
        
        requestAnimationFrame(updateIcon);
      } else {
        // アニメーション終了時、終点に配置
        const prevPoint = line.getPointAtLength(pathLength * 0.99);
        setIconPosition(icon, endPoint);
        const finalAngle = calculateIconAngle(prevPoint, endPoint, isRightSide, iconType);
        applyIconTransform(icon, finalAngle, endPoint.x, endPoint.y, isRightSide, iconType);
      }
    }
    
    updateIcon();
  }

  function animateLine(line, areaKey) {
    const pathLength = line.getTotalLength();
    const areaData = AREA_DATA[areaKey];
    const iconType = areaData?.iconType || "ship";
    const toPosition = areaData.position;
    const isRightSide = toPosition.left > JAPAN_POSITION.left;
    
    const group = line.parentElement;
    const pathThick = group.querySelector(".route-line-thick");
    const pathThin = line;
    
    const lineDuration = isRightSide ? ANIMATION_DURATION.LINE.RIGHT : ANIMATION_DURATION.LINE.LEFT;
    const iconDuration = isRightSide ? ANIMATION_DURATION.ICON.RIGHT : ANIMATION_DURATION.ICON.LEFT;
    
    setupLineAnimation(pathThick, pathThin, pathLength, lineDuration);
    
    // アイコンの取得または作成
    const svg = line.ownerSVGElement;
    let icon = state.lineIcons.get(areaKey);
    
    if (!icon) {
      icon = createIcon(svg, iconType);
      state.lineIcons.set(areaKey, icon);
    }
    
    animateIcon(icon, line, pathLength, iconDuration, isRightSide, iconType);
  }

  function hideLine(line, areaKey) {
    if (!line) return;
    const group = line.parentElement;
    if (group && group.classList.contains("route-line-group")) {
      const paths = group.querySelectorAll(".route-line");
      paths.forEach(path => {
        path.style.opacity = "0";
        path.style.strokeDashoffset = path.getTotalLength();
      });
    } else {
      line.style.opacity = "0";
      line.style.strokeDashoffset = line.getTotalLength();
    }
    
    const icon = state.lineIcons.get(areaKey);
    if (icon) {
      icon.style.opacity = "0";
    }
  }

  function showLine(line, areaKey, skipAnimation = false) {
    if (!line) return;
    
    if (skipAnimation) {
      const group = line.parentElement;
      if (group && group.classList.contains("route-line-group")) {
        const paths = group.querySelectorAll(".route-line");
        paths.forEach(path => {
          path.style.opacity = "1";
          path.style.strokeDashoffset = "0";
          path.style.transition = "none";
        });
      } else {
        line.style.opacity = "1";
        line.style.strokeDashoffset = "0";
        line.style.transition = "none";
      }
      
      // アイコンを終点に配置
      const icon = state.lineIcons.get(areaKey);
      if (icon) {
        const pathLength = line.getTotalLength();
        const endPoint = line.getPointAtLength(pathLength);
        const startPoint = line.getPointAtLength(0);
        const areaData = AREA_DATA[areaKey];
        
        if (areaData) {
          const toPosition = areaData.position;
          const isRightSide = toPosition.left > JAPAN_POSITION.left;
          const iconType = areaData?.iconType || "ship";
          
          setIconPosition(icon, endPoint);
          icon.style.opacity = "1";
          // アニメーション終了時と同じ方法で角度を計算（終点の少し前の点を使用）
          const prevPoint = line.getPointAtLength(pathLength * 0.99);
          const angle = calculateIconAngle(prevPoint, endPoint, isRightSide, iconType);
          applyIconTransform(icon, angle, endPoint.x, endPoint.y, isRightSide, iconType);
        }
      }
    } else {
      animateLine(line, areaKey);
    }
  }

  // =========================================================
  // パネル管理
  // =========================================================
  function openCard(areaKey) {
    const areaData = AREA_DATA[areaKey];
    if (!areaData) return;

    const countries = Array.isArray(areaData.countries) ? areaData.countries : [];
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
        const prevAreaKey = state.currentLine.getAttribute("data-area");
        hideLine(state.currentLine, prevAreaKey);
      }

      state.currentLine = line;
      showLine(line, areaKey, isAlreadyVisible);
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
      
      const currentAreaKey = state.currentLine?.getAttribute("data-area");
      if (currentAreaKey) {
        hideLine(state.currentLine, currentAreaKey);
      }
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
    hotspot.addEventListener("mouseenter", () => {
      if (state.fixedLine) return;
      if (state.hoveredLine === line && line.style.opacity === "1") return;

      if (state.hoveredLine && state.hoveredLine !== line) {
        const prevAreaKey = state.hoveredLine.getAttribute("data-area");
        hideLine(state.hoveredLine, prevAreaKey);
      }

      state.hoveredLine = line;
      state.currentLine = line;
      const hoverAreaKey = line.getAttribute("data-area");
      animateLine(line, hoverAreaKey);
    });

    hotspot.addEventListener("mouseleave", () => {
      if (state.fixedLine) return;
      if (state.hoveredLine === line) {
        const leaveAreaKey = line.getAttribute("data-area");
        hideLine(line, leaveAreaKey);
        state.hoveredLine = null;
        state.currentLine = null;
      }
    });

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
      const line = createLine(JAPAN_POSITION, areaData.position, svg, areaKey);
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
