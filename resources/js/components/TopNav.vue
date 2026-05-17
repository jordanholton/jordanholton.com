<template>
  <header :class="['nav-header', { scrolled: isScrolled, 'menu-open': menuOpen }]">
    <nav class="nav-inner" role="navigation" aria-label="Main navigation">

      <!-- Wordmark -->
      <a href="/" class="nav-logo" aria-label="Jordan Holton – home">
        <span class="logo-bracket" aria-hidden="true">[</span>
        <span class="logo-name">jordan holton</span>
        <span class="logo-bracket" aria-hidden="true">]</span>
        <span class="logo-cursor" aria-hidden="true">_</span>
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

      <!-- CTA -->
      <a href="mailto:hello@jordanholton.com" class="nav-cta" aria-label="Contact Jordan">
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

    <!-- Mobile menu -->
    <transition name="slide">
      <div v-if="menuOpen" id="mobile-menu" class="mobile-menu" role="dialog" aria-modal="true" aria-label="Navigation menu">
        <ul role="list">
          <li v-for="(link, i) in navLinks" :key="link.href" :style="{ animationDelay: `${i * 60}ms` }" class="mobile-link-item">
            <a
              :href="link.href"
              class="mobile-link"
              :class="{ active: activeSection === link.section }"
              @click="handleMobileNav(link.section)"
            >
              <span class="mobile-link-num" aria-hidden="true">{{ String(i + 1).padStart(2, '0') }}</span>
              {{ link.label }}
            </a>
          </li>
        </ul>
        <a href="mailto:hello@jordanholton.com" class="mobile-cta" @click="menuOpen = false">
          <span aria-hidden="true">$ </span>contact --email
        </a>
      </div>
    </transition>
  </header>
</template>

<script>
export default {
  name: 'TopNav',

  data() {
    return {
      isScrolled: false,
      menuOpen: false,
      activeSection: 'overview',
      navLinks: [
        { href: '/',         label: 'overview', section: 'overview' },
        { href: '/about',    label: 'about',    section: 'about'    },
        { href: '/work',     label: 'work',     section: 'work'     },
        { href: '/skills',   label: 'skills',   section: 'skills'   },
      ],
    }
  },

  mounted() {
    window.addEventListener('scroll', this.onScroll, { passive: true })
    document.addEventListener('keydown', this.onKeyDown)
    this.syncActiveFromPath()
  },

  beforeUnmount() {
    window.removeEventListener('scroll', this.onScroll)
    document.removeEventListener('keydown', this.onKeyDown)
  },

  methods: {
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
/* ── Tokens ─────────────────────────────────────────────── */
:root {
  --nav-height: 64px;
  --nav-bg: #0a0a0a;
  --nav-bg-scrolled: rgba(10, 10, 10, 0.92);
  --nav-border: rgba(255, 255, 255, 0.08);
  --nav-text: #c8c8c0;
  --nav-muted: #5a5a52;
  --nav-accent: #b4f16e;       /* terminal green */
  --nav-accent-dim: rgba(180, 241, 110, 0.12);
  --font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', ui-monospace, monospace;
  --font-sans: 'DM Sans', 'Inter', system-ui, sans-serif;
  --transition: 200ms cubic-bezier(0.4, 0, 0.2, 1);
}

/* ── Base ───────────────────────────────────────────────── */
.nav-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 100;
  height: var(--nav-height);
  background: var(--nav-bg);
  border-bottom: 1px solid transparent;
  transition: border-color var(--transition), background var(--transition), backdrop-filter var(--transition);
}

.nav-header.scrolled {
  background: var(--nav-bg-scrolled);
  border-bottom-color: var(--nav-border);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
}

.nav-inner {
  max-width: 1120px;
  margin: 0 auto;
  padding: 0 24px;
  height: 100%;
  display: flex;
  align-items: center;
  gap: 40px;
}

/* ── Logo ───────────────────────────────────────────────── */
.nav-logo {
  font-family: var(--font-mono);
  font-size: 14px;
  font-weight: 500;
  color: var(--nav-text);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 1px;
  letter-spacing: 0.01em;
  margin-right: auto;
  flex-shrink: 0;
  transition: color var(--transition);
}

.nav-logo:hover {
  color: #fff;
}

.logo-bracket {
  color: var(--nav-accent);
  font-weight: 700;
}

.logo-name {
  color: inherit;
}

.logo-cursor {
  color: var(--nav-accent);
  animation: blink 1.1s step-end infinite;
  margin-left: 1px;
}

@keyframes blink {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0; }
}

/* ── Desktop nav links ──────────────────────────────────── */
.nav-links {
  display: flex;
  align-items: center;
  gap: 4px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-link {
  font-family: var(--font-mono);
  font-size: 13px;
  font-weight: 400;
  color: var(--nav-muted);
  text-decoration: none;
  padding: 6px 12px;
  border-radius: 6px;
  border: 1px solid transparent;
  display: flex;
  align-items: center;
  gap: 0;
  transition: color var(--transition), background var(--transition), border-color var(--transition);
  white-space: nowrap;
}

.link-prefix {
  color: transparent;
  transition: color var(--transition);
  font-size: 11px;
  margin-right: 2px;
}

.nav-link:hover {
  color: var(--nav-text);
  background: rgba(255, 255, 255, 0.04);
}

.nav-link:hover .link-prefix {
  color: var(--nav-accent);
}

.nav-link.active {
  color: var(--nav-accent);
  background: var(--nav-accent-dim);
  border-color: rgba(180, 241, 110, 0.2);
}

.nav-link.active .link-prefix {
  color: var(--nav-accent);
}

/* ── CTA ────────────────────────────────────────────────── */
.nav-cta {
  font-family: var(--font-mono);
  font-size: 13px;
  font-weight: 500;
  color: #0a0a0a;
  background: var(--nav-accent);
  text-decoration: none;
  padding: 7px 16px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
  flex-shrink: 0;
  transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
}

.nav-cta:hover {
  background: #c8f890;
  transform: translateY(-1px);
  box-shadow: 0 4px 20px rgba(180, 241, 110, 0.3);
}

.nav-cta:active {
  transform: translateY(0);
  box-shadow: none;
}

.cta-dollar {
  opacity: 0.6;
  font-weight: 700;
}

/* ── Hamburger ──────────────────────────────────────────── */
.nav-toggle {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 5px;
  width: 36px;
  height: 36px;
  background: none;
  border: 1px solid var(--nav-border);
  border-radius: 6px;
  cursor: pointer;
  padding: 8px;
  flex-shrink: 0;
}

.hamburger-line {
  display: block;
  width: 100%;
  height: 1.5px;
  background: var(--nav-text);
  border-radius: 2px;
  transition: transform var(--transition), opacity var(--transition);
  transform-origin: center;
}

.hamburger-line:nth-child(1).open { transform: translateY(6.5px) rotate(45deg); }
.hamburger-line:nth-child(2).open { opacity: 0; transform: scaleX(0); }
.hamburger-line:nth-child(3).open { transform: translateY(-6.5px) rotate(-45deg); }

/* ── Mobile menu ────────────────────────────────────────── */
.mobile-menu {
  position: fixed;
  inset: var(--nav-height) 0 0 0;
  background: var(--nav-bg);
  padding: 32px 24px 48px;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  border-top: 1px solid var(--nav-border);
}

.mobile-menu ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.mobile-link-item {
  animation: fadeUp 0.25s ease both;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(10px); }
  to   { opacity: 1; transform: translateY(0); }
}

.mobile-link {
  font-family: var(--font-mono);
  font-size: 22px;
  font-weight: 400;
  color: var(--nav-muted);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 14px 0;
  border-bottom: 1px solid var(--nav-border);
  transition: color var(--transition);
}

.mobile-link:hover,
.mobile-link.active {
  color: var(--nav-accent);
}

.mobile-link-num {
  font-size: 12px;
  color: var(--nav-muted);
  letter-spacing: 0.05em;
  min-width: 24px;
}

.mobile-link.active .mobile-link-num {
  color: var(--nav-accent);
  opacity: 0.7;
}

.mobile-cta {
  font-family: var(--font-mono);
  font-size: 14px;
  color: var(--nav-accent);
  text-decoration: none;
  margin-top: auto;
  padding-top: 32px;
  transition: opacity var(--transition);
}

.mobile-cta:hover { opacity: 0.75; }

/* ── Slide transition ───────────────────────────────────── */
.slide-enter-active,
.slide-leave-active {
  transition: opacity 0.22s ease, transform 0.22s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}

/* ── Responsive ─────────────────────────────────────────── */
@media (max-width: 768px) {
  .nav-links,
  .nav-cta {
    display: none;
  }

  .nav-toggle {
    display: flex;
    margin-left: auto;
  }

  .nav-logo {
    margin-right: 0;
  }
}
</style>