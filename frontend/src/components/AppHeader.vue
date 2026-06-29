<template>
  <header class="app-header">
    <!-- Logo -->
    <div class="app-header__logo">
      <span class="app-header__logo-text">MOUNTY</span>
    </div>

    <!-- Tagline -->
    <p class="app-header__tagline">
      Сервіс подорожей кращими місцями Карпат
    </p>

    <!-- Social links -->
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
        <img :src="link.icon" :alt="link.name" width="20" height="20" />
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
  </header>
</template>

<script setup>
import { ref } from 'vue'

const langs = ['УКР', 'ENG']
const currentLang = ref('УКР')

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
.app-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 100;
  display: flex;
  align-items: center;
  height: var(--header-height);
  border-bottom: 1px solid var(--color-border);
  background-color: var(--color-bg);
}

/* Logo */
.app-header__logo {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--color-red);
  height: 100%;
  padding: 0 16px;
  flex-shrink: 0;
}

.app-header__logo-text {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 20px;
  letter-spacing: 0.05em;
  color: var(--color-white);
  text-transform: uppercase;
}

/* Tagline */
.app-header__tagline {
  font-family: var(--font-primary);
  font-size: 11px;
  font-weight: 400;
  line-height: 1.4;
  color: var(--color-white);
  opacity: 0.7;
  padding: 0 24px;
  max-width: 160px;
  flex-shrink: 0;
}

/* Social */
.app-header__social {
  display: flex;
  align-items: center;
  gap: 20px;
  flex: 1;
  justify-content: center;
}

.app-header__social-link {
  display: flex;
  align-items: center;
  opacity: 0.7;
  transition: opacity 0.2s;
}

.app-header__social-link:hover {
  opacity: 1;
}

.app-header__social-link img {
  width: 20px;
  height: 20px;
  filter: brightness(0) invert(1);
}

/* Language */
.app-header__lang {
  display: flex;
  align-items: center;
  gap: 4px;
  padding: 0 20px;
  flex-shrink: 0;
}

.app-header__lang-btn {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 13px;
  color: var(--color-white);
  opacity: 0.4;
  padding: 4px 6px;
  transition: opacity 0.2s;
  letter-spacing: 0.05em;
}

.app-header__lang-btn:hover,
.app-header__lang-btn.is-active {
  opacity: 1;
}
</style>
