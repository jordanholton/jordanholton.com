/**
 * useTheme — dark / light mode composable
 *
 * Module-level reactive state so it's shared across all component instances
 * without needing a global store. Persists to localStorage and respects
 * the OS prefers-color-scheme on first visit.
 */

import { computed, ref, watch } from 'vue'

type Theme = 'dark' | 'light'

// ── Reactive state (module-level = singleton) ─────────────────────
const theme = ref<Theme>('dark')

// ── Initialise from storage / OS preference ───────────────────────
if (typeof window !== 'undefined') {
    const stored = localStorage.getItem('theme') as Theme | null
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
    theme.value = stored ?? (prefersDark ? 'dark' : 'light')
    // Apply immediately (before Vue mounts) — mirrors the blade anti-flash script
    document.documentElement.setAttribute('data-theme', theme.value)
}

// ── Sync data-theme attribute + localStorage whenever theme changes ─
watch(theme, (t: Theme) => {
    document.documentElement.setAttribute('data-theme', t)
    localStorage.setItem('theme', t)
})

// ── Composable ────────────────────────────────────────────────────
export function useTheme() {
    const isDark = computed(() => theme.value === 'dark')

    function toggle() {
        // Add transition class to smooth the colour shift
        document.documentElement.classList.add('theme-transitioning')
        theme.value = theme.value === 'dark' ? 'light' : 'dark'
        window.setTimeout(() => {
            document.documentElement.classList.remove('theme-transitioning')
        }, 320)
    }

    return { theme, isDark, toggle }
}
