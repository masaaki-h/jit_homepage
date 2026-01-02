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
    $(".fa-bars").on("click", function () {
      $("nav").toggle(200);
    });
  });
  
});