/* brainerd.js — mosaic parallax + dark-mode toggle */
(function () {
  'use strict';

  /* ── Dark mode toggle ─────────────────────────────────────────────────── */
  var DARK_KEY = 'tmd-dark';

  function applyDark(on) {
    document.documentElement.classList.toggle('tmd-dark', on);
    document.documentElement.classList.toggle('tmd-light', !on);
    try { localStorage.setItem(DARK_KEY, on ? '1' : '0'); } catch (e) {}
    document.querySelectorAll('[data-dark-toggle]').forEach(function (btn) {
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
      var label = btn.querySelector('[data-dark-toggle-label]');
      if (label) label.textContent = on ? 'Light mode' : 'Dark mode';
    });
  }

  function isDark() {
    return document.documentElement.classList.contains('tmd-dark');
  }

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-dark-toggle]');
    if (btn) applyDark(!isDark());
  });

  /* ── Mosaic — page-wide subtle parallax + staggered entrance ──────────── */
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (!reducedMotion) {
    document.querySelectorAll('[data-mosaic]').forEach(function (mosaic) {
      var tiles = mosaic.querySelectorAll('.cb-hero__mosaic-tile');
      var rotations = [-2, 1.5, -1, 2.5];
      var depths = [1, -0.7, 0.6, -0.9];
      var cx = 0, cy = 0, tx = 0, ty = 0;
      var running = false;

      function lerp(a, b, t) { return a + (b - a) * t; }

      function tick() {
        tx = lerp(tx, cx, 0.04);
        ty = lerp(ty, cy, 0.04);

        tiles.forEach(function (tile, i) {
          var d = depths[i] || 1;
          var r = rotations[i] || 0;
          var x = (tx * 5 * d).toFixed(2);
          var y = (ty * 4 * d).toFixed(2);
          tile.style.transform = 'rotate(' + r + 'deg) translate(' + x + 'px,' + y + 'px)';
        });

        if (running) requestAnimationFrame(tick);
      }

      document.addEventListener('mousemove', function (e) {
        cx = (e.clientX / window.innerWidth  - 0.5) * 2;
        cy = (e.clientY / window.innerHeight - 0.5) * 2;
      });

      /* ── Staggered entrance ──────────────────────────────────────────── */
      tiles.forEach(function (tile) {
        tile.style.opacity = '0';
        tile.style.transform = 'rotate(0deg) translateY(30px) scale(0.92)';
      });

      function staggerIn() {
        tiles.forEach(function (tile, i) {
          var r = rotations[i] || 0;
          setTimeout(function () {
            tile.style.transition = 'opacity 0.7s ease, transform 0.7s cubic-bezier(0.23, 1, 0.32, 1)';
            tile.style.opacity = '1';
            tile.style.transform = 'rotate(' + r + 'deg) translateY(0) scale(1)';
            setTimeout(function () { tile.style.transition = ''; }, 800);
          }, 150 * i);
        });
      }

      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            staggerIn();
            running = true;
            requestAnimationFrame(tick);
            observer.disconnect();
          }
        });
      }, { threshold: 0.1 });

      observer.observe(mosaic);
    });
  }

  /* ── Hero text fade-up ───────────────────────────────────────────────── */
  var heroText = document.querySelector('.cb-hero__text');
  if (heroText && !reducedMotion) {
    heroText.style.opacity = '0';
    heroText.style.transform = 'translateY(24px)';
    requestAnimationFrame(function () {
      heroText.style.transition = 'opacity 0.65s ease 0.1s, transform 0.65s ease 0.1s';
      heroText.style.opacity = '1';
      heroText.style.transform = 'translateY(0)';
    });
  }
})();
