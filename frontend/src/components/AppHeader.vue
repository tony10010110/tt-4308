<template>
  <header class="app-header">
    <!-- Logo -->
    <div class="app-header__logo">
      <span class="app-header__logo-text">MOUNTY</span>
    </div>

    <!-- Tagline (hidden on mobile) -->
    <p class="app-header__tagline">
      Сервіс подорожей кращими<br />місцями Карпат
    </p>

    <!-- Social links (hidden on mobile) -->
    <nav class="app-header__social" aria-label="Соціальні мережі">
      <a
        v-for="link in socialLinks"
        :key="link.name"
        :href="link.url"
        :aria-label="link.name"
        class="app-header__social-link"
        target="_blank"
        rel="noopener noreferrer"
      >
        <img :src="link.icon" :alt="link.name" width="18" height="18" />
      </a>
    </nav>

    <!-- Language switcher -->
    <div class="app-header__lang">
      <button
        v-for="lang in langs"
        :key="lang"
        class="app-header__lang-btn"
        :class="{ 'is-active': currentLang === lang }"
        @click="currentLang = lang"
      >
        {{ lang }}
      </button>
    </div>

    <!-- Mobile burger -->
    <button class="app-header__burger" @click="mobileOpen = !mobileOpen" aria-label="Меню">
      <span /><span /><span />
    </button>

    <!-- Mobile dropdown nav -->
    <div class="app-header__mobile-nav" :class="{ 'is-open': mobileOpen }">
      <a
        v-for="item in navItems"
        :key="item.label"
        :href="item.href"
        class="app-header__mobile-link"
        @click="mobileOpen = false"
      >{{ item.label }}</a>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'

const langs = ['УКР', 'ENG']
const currentLang = ref('УКР')
const mobileOpen = ref(false)

const navItems = [
  { label: 'ЦІНИ',        href: '#prices' },
  { label: 'ПРО МАУНТІ',  href: '#about' },
  { label: 'СПОРЯДЖЕННЯ', href: '#equipment' },
  { label: 'МАРШРУТИ',    href: '#routes' },
  { label: 'FAQ',         href: '/faq' },
]

const socialLinks = [
  { name: 'Instagram', url: '#', icon: '/icons/instagram.svg' },
  { name: 'TikTok',    url: '#', icon: '/icons/tiktok.svg' },
  { name: 'WhatsApp',  url: '#', icon: '/icons/whatsapp.svg' },
  { name: 'Telegram',  url: '#', icon: '/icons/telegram.svg' },
  { name: 'Twitter',   url: '#', icon: '/icons/twitter.svg' },
  { name: 'YouTube',   url: '#', icon: '/icons/youtube.svg' },
  { name: 'Spotify',   url: '#', icon: '/icons/spotify.svg' },
]
</script>

<style scoped>
/* ─── Base ───────────────────────────────────────────────────── */
.app-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 100;
  display: flex;
  align-items: center;
  height: var(--header-height);
  /* Transparent — overlays hero image */
  background: transparent;
  border-bottom: 1px solid var(--color-border);
}

/* ─── Logo ───────────────────────────────────────────────────── */
.app-header__logo {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--color-red);
  height: 100%;
  padding: 0 14px;
  flex-shrink: 0;
}

.app-header__logo-text {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 18px;
  letter-spacing: 0.06em;
  color: var(--color-white);
  text-transform: uppercase;
}

/* ─── Tagline ────────────────────────────────────────────────── */
.app-header__tagline {
  font-family: var(--font-primary);
  font-size: 11px;
  font-weight: 400;
  line-height: 1.4;
  color: var(--color-white);
  opacity: 0.65;
  padding: 0 20px;
  flex-shrink: 0;
  border-right: 1px solid var(--color-border);
  align-self: stretch;
  display: flex;
  align-items: center;
}

/* ─── Social ─────────────────────────────────────────────────── */
.app-header__social {
  display: flex;
  align-items: center;
  gap: 18px;
  flex: 1;
  justify-content: center;
}

.app-header__social-link {
  display: flex;
  align-items: center;
  opacity: 0.65;
  transition: opacity 0.2s;
}

.app-header__social-link:hover {
  opacity: 1;
}

.app-header__social-link img {
  width: 18px;
  height: 18px;
  filter: brightness(0) invert(1);
}

/* ─── Language ───────────────────────────────────────────────── */
.app-header__lang {
  display: flex;
  align-items: center;
  padding: 0 16px;
  gap: 2px;
  flex-shrink: 0;
  align-self: stretch;
  border-left: 1px solid var(--color-border);
}

.app-header__lang-btn {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 12px;
  letter-spacing: 0.05em;
  color: var(--color-white);
  opacity: 0.4;
  padding: 4px 5px;
  transition: opacity 0.2s;
}

.app-header__lang-btn:hover,
.app-header__lang-btn.is-active {
  opacity: 1;
}

/* ─── Burger (mobile only) ───────────────────────────────────── */
.app-header__burger {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 5px;
  width: 44px;
  height: 100%;
  padding: 0 12px;
  flex-shrink: 0;
  border-left: 1px solid var(--color-border);
}

.app-header__burger span {
  display: block;
  width: 20px;
  height: 2px;
  background-color: var(--color-white);
  transition: transform 0.2s, opacity 0.2s;
}

/* ─── Mobile nav dropdown ────────────────────────────────────── */
.app-header__mobile-nav {
  display: none;
  position: fixed;
  top: var(--header-height);
  left: 0;
  right: 0;
  background-color: var(--color-bg);
  border-bottom: 1px solid var(--color-border);
  flex-direction: column;
  z-index: 99;
}

.app-header__mobile-nav.is-open {
  display: flex;
}

.app-header__mobile-link {
  padding: 16px 24px;
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: var(--color-white);
  border-bottom: 1px solid var(--color-border);
  transition: background-color 0.2s;
}

.app-header__mobile-link:hover {
  background-color: var(--color-red);
}

/* ─── Responsive ─────────────────────────────────────────────── */
@media (max-width: 1024px) {
  .app-header__tagline {
    display: none;
  }
}

@media (max-width: 768px) {
  .app-header__social {
    display: none;
  }

  .app-header__lang {
    display: none;
  }

  .app-header__burger {
    display: flex;
    margin-left: auto;
  }
}
</style>
