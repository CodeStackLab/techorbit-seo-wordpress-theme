/**
 * Main JS — TechOrbit SEO Theme
 * Navigation, stats counter, smooth scroll
 */

(function () {
  'use strict';

  /* ---- DOM Ready ---- */
  document.addEventListener('DOMContentLoaded', function () {
    initStickyHeader();
    initMobileMenu();
    initStatsCounter();
    initSmoothScroll();
    initNavHighlight();
    initLiveSearch();
  });

  /* ---- STICKY HEADER ---- */
  function initStickyHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;

    window.addEventListener('scroll', function () {
      if (window.scrollY > 10) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }, { passive: true });
  }

  /* ---- MOBILE MENU ---- */
  function initMobileMenu() {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const nav = document.getElementById('primary-nav');
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener('click', function () {
      const isOpen = nav.classList.toggle('open');
      toggleBtn.classList.toggle('active', isOpen);
      toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

      if (isOpen) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    });

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!nav.contains(e.target) && !toggleBtn.contains(e.target)) {
        nav.classList.remove('open');
        toggleBtn.classList.remove('active');
        toggleBtn.setAttribute('aria-expanded', 'false');
      }
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        nav.classList.remove('open');
        toggleBtn.classList.remove('active');
        toggleBtn.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* ---- ANIMATED STATS COUNTER ---- */
  function initStatsCounter() {
    const statNumbers = document.querySelectorAll('.stat-number[data-count]');
    if (!statNumbers.length) return;

    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.3 });

    statNumbers.forEach(function (el) {
      observer.observe(el);
    });
  }

  function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-count'), 10);
    const suffix = el.getAttribute('data-suffix') || '';
    const duration = 1800;
    const start = performance.now();

    function update(now) {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      // Ease out cubic
      const ease = 1 - Math.pow(1 - progress, 3);
      const current = Math.round(ease * target);
      el.textContent = current.toLocaleString() + suffix;

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        el.textContent = target.toLocaleString() + suffix;
      }
    }

    requestAnimationFrame(update);
  }

  /* ---- SMOOTH SCROLL ---- */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        const targetId = link.getAttribute('href').slice(1);
        if (!targetId) return;
        const targetEl = document.getElementById(targetId);
        if (!targetEl) return;
        e.preventDefault();
        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  }

  /* ---- ACTIVE NAV HIGHLIGHT ---- */
  function initNavHighlight() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-menu a').forEach(function (link) {
      try {
        const linkPath = new URL(link.href).pathname;
        if (linkPath === currentPath || (linkPath !== '/' && currentPath.startsWith(linkPath))) {
          link.closest('li')?.classList.add('current-menu-item');
        }
      } catch (e) { }
    });
  }

  /* ---- UTILITY: Copy to Clipboard ---- */
  window.techorbitCopy = function (text, btnEl) {
    const strings = (typeof techorbit_vars !== 'undefined') ? techorbit_vars.strings : {};

    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text).then(function () {
        showCopySuccess(btnEl, strings.copy_success || 'Copied!');
      }).catch(function () {
        fallbackCopy(text, btnEl, strings);
      });
    } else {
      fallbackCopy(text, btnEl, strings);
    }
  };

  function fallbackCopy(text, btnEl, strings) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.cssText = 'position:fixed;opacity:0;';
    document.body.appendChild(textarea);
    textarea.select();
    try {
      document.execCommand('copy');
      showCopySuccess(btnEl, strings.copy_success || 'Copied!');
    } catch (e) {
      alert(strings.copy_fail || 'Copy failed. Please select and copy manually.');
    }
    document.body.removeChild(textarea);
  }

  function showCopySuccess(btnEl, msg) {
    if (!btnEl) return;
    const original = btnEl.innerHTML;
    btnEl.innerHTML = '✅ ' + msg;
    btnEl.classList.add('copied');
    setTimeout(function () {
      btnEl.innerHTML = original;
      btnEl.classList.remove('copied');
    }, 2000);
  }

  /* ---- LIVE SEARCH SUGGESTIONS ---- */
  function initLiveSearch() {
    const searchInput = document.getElementById('hero-search');
    const suggestionsBox = document.getElementById('search-suggestions');
    if (!searchInput || !suggestionsBox || !window.techorbit_vars || !window.techorbit_vars.tools_registry) return;

    const tools = window.techorbit_vars.tools_registry;

    searchInput.addEventListener('input', function () {
      const query = this.value.toLowerCase().trim();
      if (query.length < 2) {
        suggestionsBox.classList.remove('active');
        return;
      }

      const matches = Object.entries(tools).filter(([slug, tool]) => {
        return tool.name.toLowerCase().includes(query) ||
          tool.desc.toLowerCase().includes(query) ||
          tool.cat.toLowerCase().includes(query);
      }).slice(0, 6); // Limit to top 6

      if (matches.length > 0) {
        renderSuggestions(matches);
        suggestionsBox.classList.add('active');
      } else {
        suggestionsBox.classList.remove('active');
      }
    });

    function renderSuggestions(matches) {
      const siteUrl = window.techorbit_vars.site_url;
      suggestionsBox.innerHTML = matches.map(([slug, tool]) => {
        // Ensure tool.url doesn't double slash
        const rawUrl = tool.url || '';
        const cleanUrl = rawUrl.startsWith('/') ? rawUrl.substring(1) : rawUrl;
        const finalUrl = siteUrl + cleanUrl;

        return `
          <a href="${finalUrl}" class="suggestion-item">
            <div class="suggestion-icon">${tool.icon}</div>
            <div class="suggestion-info">
              <div class="suggestion-name">${tool.name}</div>
              <div class="suggestion-desc">${tool.desc}</div>
            </div>
            <div class="suggestion-cat">${tool.cat}</div>
          </a>
        `;
      }).join('');
    }

    // Close on outside click
    document.addEventListener('click', function (e) {
      if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
        suggestionsBox.classList.remove('active');
      }
    });

    // Close on Escape
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        suggestionsBox.classList.remove('active');
      }
    });
  }

})();
