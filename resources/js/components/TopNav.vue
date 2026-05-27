<template>
  <header :class="['nav-header', { scrolled: isScrolled, 'menu-open': menuOpen }]">
    <nav class="nav-inner" role="navigation" aria-label="Main navigation">

      <!-- Wordmark -->
      <a href="/" class="nav-logo" aria-label="Jordan Holton – home">
        <span class="logo-bracket" aria-hidden="true">[</span>
        <span class="logo-name">jordan.holton</span>
        <span class="logo-bracket" aria-hidden="true">]</span>
      </a>

      <!-- Desktop links -->
      <ul class="nav-links" role="list">
        <li v-for="link in navLinks" :key="link.href">
          <a
            :href="link.href"
            class="nav-link"
            :class="{ active: activeSection === link.section }"
            @click="setActive(link.section)"
          >
            <span class="link-prefix" aria-hidden="true">./</span>{{ link.label }}
          </a>
        </li>
      </ul>

      <!-- Theme toggle (always visible) -->
      <button
        class="theme-toggle"
        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
        :title="isDark ? 'Light mode' : 'Dark mode'"
        @click="toggle"
      >
        <!-- Sun — click to switch to light -->
        <svg v-if="isDark" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="5"/>
          <line x1="12" y1="1" x2="12" y2="3"/>
          <line x1="12" y1="21" x2="12" y2="23"/>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
          <line x1="1" y1="12" x2="3" y2="12"/>
          <line x1="21" y1="12" x2="23" y2="12"/>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
          <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
        </svg>
        <!-- Moon — click to switch to dark -->
        <svg v-else xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
        </svg>
      </button>

      <!-- Desktop CTA -->
      <a href="mailto:jordan@jordanholton.com" class="nav-cta" aria-label="Contact Jordan">
        <span class="cta-dollar" aria-hidden="true">$</span>
        contact
      </a>

      <!-- Mobile hamburger -->
      <button
        class="nav-toggle"
        :aria-expanded="menuOpen.toString()"
        aria-controls="mobile-menu"
        aria-label="Toggle menu"
        @click="toggleMenu"
      >
        <span class="hamburger-line" :class="{ open: menuOpen }" aria-hidden="true"></span>
        <span class="hamburger-line" :class="{ open: menuOpen }" aria-hidden="true"></span>
        <span class="hamburger-line" :class="{ open: menuOpen }" aria-hidden="true"></span>
      </button>
    </nav>

    <!-- Mobile backdrop -->
    <transition name="backdrop">
      <div
        v-if="menuOpen"
        class="mobile-backdrop"
        aria-hidden="true"
        @click="toggleMenu"
      ></div>
    </transition>

    <!-- Mobile drawer -->
    <transition name="drawer">
      <div v-if="menuOpen" id="mobile-menu" class="mobile-drawer" role="dialog" aria-modal="true" aria-label="Navigation menu">
        <!-- Drawer header -->
        <div class="drawer-header">
          <span class="drawer-logo">
            <span class="logo-bracket">[</span>jordan.holton<span class="logo-bracket">]</span>
          </span>
          <button class="drawer-close" aria-label="Close menu" @click="toggleMenu">✕</button>
        </div>

        <!-- Links -->
        <nav class="drawer-nav">
          <a
            v-for="(link, i) in navLinks"
            :key="link.href"
            :href="link.href"
            class="drawer-link"
            :class="{ active: activeSection === link.section }"
            :style="{ animationDelay: `${i * 40}ms` }"
            @click="handleMobileNav(link.section)"
          >
            <span class="drawer-prefix" aria-hidden="true">./</span>{{ link.label }}
          </a>
        </nav>

        <!-- Contact CTA -->
        <div class="drawer-footer">
          <a href="mailto:jordan@jordanholton.com" class="drawer-cta" @click="menuOpen = false">
            <span class="cta-dollar" aria-hidden="true">$</span> contact --email
          </a>
        </div>
      </div>
    </transition>
  </header>
</template>

<script>
import { useTheme } from '@/composables/useTheme'

export default {
  name: 'TopNav',

  setup() {
    const { isDark, toggle } = useTheme()
    return { isDark, toggle }
  },

  data() {
    return {
      isScrolled: false,
      menuOpen: false,
      activeSection: 'overview',
      navLinks: [
        { href: '/',        label: 'overview', section: 'overview' },
        { href: '/about',   label: 'about',    section: 'about'   },
        { href: '/work',    label: 'work',     section: 'work'    },
        { href: '/skills',  label: 'skills',   section: 'skills'  },
        { href: '/moments', label: 'moments',  section: 'moments' },
      ],
    }
  },

  mounted() {
    this.loadFonts()
    window.addEventListener('scroll', this.onScroll, { passive: true })
    document.addEventListener('keydown', this.onKeyDown)
    this.syncActiveFromPath()
  },

  beforeUnmount() {
    window.removeEventListener('scroll', this.onScroll)
    document.removeEventListener('keydown', this.onKeyDown)
  },

  methods: {
    loadFonts() {
      if (document.getElementById('jetbrains-mono-font')) return
      const preconnect1 = Object.assign(document.createElement('link'), {
        rel: 'preconnect', href: 'https://fonts.googleapis.com',
      })
      const preconnect2 = Object.assign(document.createElement('link'), {
        rel: 'preconnect', href: 'https://fonts.gstatic.com', crossOrigin: 'anonymous',
      })
      const stylesheet = Object.assign(document.createElement('link'), {
        id: 'jetbrains-mono-font',
        rel: 'stylesheet',
        href: 'https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=DM+Sans:wght@400;500&display=swap',
      })
      document.head.append(preconnect1, preconnect2, stylesheet)
    },

    onScroll() {
      this.isScrolled = window.scrollY > 24
    },

    toggleMenu() {
      this.menuOpen = !this.menuOpen
      document.body.style.overflow = this.menuOpen ? 'hidden' : ''
    },

    setActive(section) {
      this.activeSection = section
    },

    handleMobileNav(section) {
      this.setActive(section)
      this.menuOpen = false
      document.body.style.overflow = ''
    },

    onKeyDown(e) {
      if (e.key === 'Escape' && this.menuOpen) {
        this.menuOpen = false
        document.body.style.overflow = ''
      }
    },

    syncActiveFromPath() {
      const path = window.location.pathname
      const match = this.navLinks.find(l => l.href === path)
      if (match) this.activeSection = match.section
    },
  },
}
</script>

<style scoped>
/* ── Base ────────────────────────────────────────────────────────── */
.nav-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 200;
  height: var(--nav-height);
  background: var(--bg);
  border-bottom: 1px solid transparent;
  transition: border-color 200ms ease, background 200ms ease, backdrop-filter 200ms ease;
}

.nav-header.scrolled {
  background: var(--nav-scrolled-bg);
  border-bottom-color: var(--border);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
}

/* ── Inner: aligned with .container (max-w 1120px, px-6) ──────── */
.nav-inner {
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 24px;
  height: 100%;
  display: flex;
  align-items: center;
  gap: 28px;
}

/* ── Logo ────────────────────────────────────────────────────────── */
.nav-logo {
  font-family: var(--font-mono);
  font-size: 14px;
  font-weight: 500;
  color: var(--text);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 1px;
  letter-spacing: 0.01em;
  margin-right: auto;
  flex-shrink: 0;
  transition: color 200ms ease;
}
.nav-logo:hover { color: var(--text); opacity: 0.8; }

.logo-bracket { color: var(--accent); font-weight: 700; }
.logo-name    { color: inherit; }

/* ── Desktop links ───────────────────────────────────────────────── */
.nav-links {
  display: flex;
  align-items: center;
  gap: 2px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-link {
  font-family: var(--font-mono);
  font-size: 12.5px;
  color: var(--text-muted);
  text-decoration: none;
  padding: 6px 10px;
  border-radius: 6px;
  border: 1px solid transparent;
  display: flex;
  align-items: center;
  transition: color 200ms ease, background 200ms ease, border-color 200ms ease;
  white-space: nowrap;
}
.link-prefix {
  color: transparent;
  font-size: 10px;
  margin-right: 1px;
  transition: color 200ms ease;
}
.nav-link:hover {
  color: var(--text);
  background: var(--hover-surface);
}
.nav-link:hover .link-prefix { color: var(--accent); }
.nav-link.active {
  color: var(--accent);
  background: var(--accent-dim);
  border-color: var(--border-accent);
}
.nav-link.active .link-prefix { color: var(--accent); }

/* ── Theme toggle ────────────────────────────────────────────────── */
.theme-toggle {
  width: 34px;
  height: 34px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: none;
  border: 1px solid var(--border);
  border-radius: 6px;
  color: var(--text-muted);
  cursor: pointer;
  flex-shrink: 0;
  transition: color 200ms ease, border-color 200ms ease, background 200ms ease;
}
.theme-toggle:hover {
  color: var(--accent);
  border-color: var(--border-accent);
  background: var(--accent-dim);
}
.theme-toggle svg {
  transition: transform 0.35s ease;
  display: block;
}
.theme-toggle:hover svg { transform: rotate(18deg); }

/* ── CTA ─────────────────────────────────────────────────────────── */
.nav-cta {
  font-family: var(--font-mono);
  font-size: 12.5px;
  font-weight: 500;
  color: var(--bg);
  background: var(--accent);
  text-decoration: none;
  padding: 7px 16px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
  flex-shrink: 0;
  transition: background 200ms ease, transform 200ms ease, box-shadow 200ms ease;
}
.nav-cta:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 20px var(--accent-glow);
  filter: brightness(1.08);
}
.nav-cta:active { transform: translateY(0); box-shadow: none; }
.cta-dollar { opacity: 0.6; font-weight: 700; }

/* ── Hamburger ───────────────────────────────────────────────────── */
.nav-toggle {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 5px;
  width: 36px;
  height: 36px;
  background: none;
  border: 1px solid var(--border);
  border-radius: 6px;
  cursor: pointer;
  padding: 8px;
  flex-shrink: 0;
}
.hamburger-line {
  display: block;
  width: 100%;
  height: 1.5px;
  background: var(--text);
  border-radius: 2px;
  transition: transform 200ms ease, opacity 200ms ease;
  transform-origin: center;
}
.hamburger-line:nth-child(1).open { transform: translateY(6.5px) rotate(45deg); }
.hamburger-line:nth-child(2).open { opacity: 0; transform: scaleX(0); }
.hamburger-line:nth-child(3).open { transform: translateY(-6.5px) rotate(-45deg); }

/* ── Mobile backdrop ─────────────────────────────────────────────── */
.mobile-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.55);
  z-index: 190;
  cursor: pointer;
}

/* ── Mobile drawer ───────────────────────────────────────────────── */
.mobile-drawer {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  width: min(300px, 85vw);
  background: var(--bg-surface);
  border-left: 1px solid var(--border);
  z-index: 250;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  overscroll-behavior: contain;
}

.drawer-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  height: var(--nav-height);
  border-bottom: 1px solid var(--border);
  flex-shrink: 0;
}
.drawer-logo {
  font-family: var(--font-mono);
  font-size: 13px;
  font-weight: 500;
  color: var(--text);
}
.drawer-close {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: none;
  border: 1px solid var(--border);
  border-radius: 6px;
  color: var(--text-muted);
  font-size: 12px;
  cursor: pointer;
  transition: color 200ms ease, border-color 200ms ease;
}
.drawer-close:hover { color: var(--text); border-color: var(--border-hover); }

.drawer-nav {
  display: flex;
  flex-direction: column;
  padding: 16px 12px;
  gap: 2px;
  flex: 1;
}
.drawer-link {
  font-family: var(--font-mono);
  font-size: 14px;
  color: var(--text-muted);
  text-decoration: none;
  padding: 12px 12px;
  border-radius: 6px;
  border: 1px solid transparent;
  display: flex;
  align-items: center;
  transition: color 200ms ease, background 200ms ease, border-color 200ms ease;
  animation: fadeInLink 0.2s ease both;
}
@keyframes fadeInLink {
  from { opacity: 0; transform: translateX(12px); }
  to   { opacity: 1; transform: translateX(0); }
}
.drawer-prefix {
  color: transparent;
  font-size: 11px;
  margin-right: 3px;
  transition: color 200ms ease;
}
.drawer-link:hover {
  color: var(--text);
  background: var(--hover-surface);
}
.drawer-link:hover .drawer-prefix { color: var(--accent); }
.drawer-link.active {
  color: var(--accent);
  background: var(--accent-dim);
  border-color: var(--border-accent);
}
.drawer-link.active .drawer-prefix { color: var(--accent); }

.drawer-footer {
  padding: 16px 20px 32px;
  border-top: 1px solid var(--border);
}
.drawer-cta {
  font-family: var(--font-mono);
  font-size: 13px;
  font-weight: 500;
  color: var(--bg);
  background: var(--accent);
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 11px 16px;
  border-radius: 6px;
  transition: filter 200ms ease;
}
.drawer-cta:hover { filter: brightness(1.08); }

/* ── Backdrop transition ─────────────────────────────────────────── */
.backdrop-enter-active, .backdrop-leave-active { transition: opacity 0.25s ease; }
.backdrop-enter-from, .backdrop-leave-to { opacity: 0; }

/* ── Drawer slide transition ─────────────────────────────────────── */
.drawer-enter-active  { transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.28s ease; }
.drawer-leave-active  { transition: transform 0.22s cubic-bezier(0.4, 0, 1, 1), opacity 0.22s ease; }
.drawer-enter-from, .drawer-leave-to { transform: translateX(100%); opacity: 0.6; }

/* ── Responsive ──────────────────────────────────────────────────── */
@media (max-width: 960px) {
  .nav-links,
  .nav-cta { display: none; }
  .nav-toggle {
    display: flex;
  }
  /* On mobile: logo | [gap] | theme-toggle | hamburger */
  .nav-logo { margin-right: 0; }
  .theme-toggle { margin-left: auto; }
}

@media (max-width: 480px) {
  .drawer-link { padding: 14px 12px; font-size: 15px; }
}
</style>
