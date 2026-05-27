<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import TopNav from '@/components/TopNav.vue'
import SiteFooter from '@/components/SiteFooter.vue'
import { ref, computed, onMounted } from 'vue'

interface Moment {
    id: number
    title: string
    date: string
    body: string
    category: 'personal' | 'professional' | 'milestone'
}

const props = defineProps<{ moments: Moment[] }>()

const visible = ref(false)
const activeFilter = ref<string>('all')

onMounted(() => setTimeout(() => { visible.value = true }, 80))

const filters = [
    { key: 'all', label: 'all' },
    { key: 'milestone', label: 'milestone' },
    { key: 'professional', label: 'professional' },
    { key: 'personal', label: 'personal' },
]

const filtered = computed(() => {
    if (activeFilter.value === 'all') return props.moments
    return props.moments.filter(m => m.category === activeFilter.value)
})

function formatDate(dateStr: string): string {
    const d = new Date(dateStr + 'T00:00:00')
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}

function catLabel(cat: string): string {
    return cat
}
</script>

<template>
    <Head title="Moments – Jordan Holton" />
    <TopNav />

    <div class="page-wrap">
        <main>
            <section class="moments-section">
                <div class="container">
                    <div class="page-header" :class="{ visible }">
                        <p class="section-label"><span class="sl">$ </span>tail -f ./moments.log</p>
                        <h1 class="page-title">Moments</h1>
                        <p class="page-sub">A running log of personal updates, milestones, and things worth remembering.</p>
                    </div>

                    <!-- Filters -->
                    <div class="filters" :class="{ visible }">
                        <button
                            v-for="f in filters"
                            :key="f.key"
                            class="filter-btn"
                            :class="{ active: activeFilter === f.key }"
                            @click="activeFilter = f.key"
                        >
                            <span class="filter-prefix">./</span>{{ f.label }}
                        </button>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline" :class="{ visible }">
                        <transition-group name="entry" tag="div" class="timeline-inner">
                            <div
                                v-if="filtered.length === 0"
                                key="empty"
                                class="empty"
                            >
                                <span class="empty-prompt">$</span>
                                <span class="empty-msg"> no entries found</span>
                            </div>

                            <div
                                v-for="(moment, i) in filtered"
                                :key="moment.id"
                                class="entry"
                                :style="{ transitionDelay: `${i * 50}ms` }"
                            >
                                <div class="entry-marker">
                                    <div class="marker-dot"></div>
                                    <div class="marker-line"></div>
                                </div>
                                <div class="entry-content">
                                    <div class="entry-meta">
                                        <span class="entry-date">{{ formatDate(moment.date) }}</span>
                                        <span class="entry-cat" :class="moment.category">{{ catLabel(moment.category) }}</span>
                                    </div>
                                    <h3 class="entry-title">
                                        <span class="entry-prefix">▸ </span>{{ moment.title }}
                                    </h3>
                                    <p class="entry-body">{{ moment.body }}</p>
                                </div>
                            </div>
                        </transition-group>
                    </div>
                </div>
            </section>
        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
.moments-section { padding: 80px 0 96px; }

.page-header {
    opacity: 0; transform: translateY(16px);
    transition: opacity 0.5s var(--ease), transform 0.5s var(--ease);
    margin-bottom: 48px;
}
.page-header.visible { opacity: 1; transform: translateY(0); }

.page-title {
    font-family: var(--font-mono);
    font-size: clamp(40px, 6vw, 72px);
    font-weight: 700; color: var(--text-strong);
    letter-spacing: -0.02em; line-height: 1.05;
    margin-bottom: 16px;
}
.page-sub { font-size: 16px; color: var(--text-muted); max-width: 500px; }

/* Filters */
.filters {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 56px;
    opacity: 0; transform: translateY(10px);
    transition: opacity 0.5s var(--ease) 0.1s, transform 0.5s var(--ease) 0.1s;
}
.filters.visible { opacity: 1; transform: translateY(0); }

.filter-btn {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
    background: none;
    border: 1px solid var(--border);
    padding: 6px 14px;
    border-radius: 6px;
    cursor: pointer;
    transition: color var(--transition), border-color var(--transition), background var(--transition);
}
.filter-btn:hover { color: var(--text); border-color: var(--border-hover); }
.filter-btn.active {
    color: var(--accent);
    border-color: var(--border-accent);
    background: var(--accent-dim);
}
.filter-prefix { color: var(--accent); opacity: 0.5; }
.filter-btn.active .filter-prefix { opacity: 1; }

/* Timeline */
.timeline {
    max-width: 720px;
    opacity: 0; transform: translateY(20px);
    transition: opacity 0.55s var(--ease) 0.15s, transform 0.55s var(--ease) 0.15s;
}
.timeline.visible { opacity: 1; transform: translateY(0); }

.timeline-inner { display: flex; flex-direction: column; }

.entry {
    display: grid;
    grid-template-columns: 24px 1fr;
    gap: 0 20px;
    margin-bottom: 0;
}

.entry-marker {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 5px;
}
.marker-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--bg);
    border: 2px solid var(--accent);
    flex-shrink: 0;
    box-shadow: 0 0 8px rgba(180, 241, 110, 0.2);
}
.marker-line {
    width: 1px;
    flex: 1;
    background: var(--border);
    margin-top: 8px;
    min-height: 40px;
}
.entry:last-child .marker-line { display: none; }

.entry-content {
    padding-bottom: 48px;
}

.entry-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}
.entry-date {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-muted);
}
.entry-cat {
    font-family: var(--font-mono);
    font-size: 9px;
    padding: 2px 7px;
    border-radius: 3px;
}
.entry-cat.personal    { background: rgba(110,180,241,0.1); color: var(--blue); border: 1px solid rgba(110,180,241,0.2); }
.entry-cat.professional { background: var(--accent-dim); color: var(--accent); border: 1px solid var(--border-accent); }
.entry-cat.milestone   { background: rgba(241,196,110,0.1); color: var(--amber); border: 1px solid rgba(241,196,110,0.2); }

.entry-title {
    font-family: var(--font-mono);
    font-size: 16px;
    font-weight: 500;
    color: var(--text-strong);
    margin-bottom: 10px;
    line-height: 1.4;
}
.entry-prefix { color: var(--accent); opacity: 0.7; }

.entry-body {
    font-size: 15px;
    color: var(--text-muted);
    line-height: 1.7;
}

/* Empty state */
.empty {
    font-family: var(--font-mono);
    font-size: 14px;
    color: var(--text-muted);
    padding: 48px 0;
}
.empty-prompt { color: var(--accent); margin-right: 6px; }

/* Transition */
.entry-enter-active { transition: opacity 0.3s ease, transform 0.3s ease; }
.entry-leave-active { transition: opacity 0.2s ease; }
.entry-enter-from { opacity: 0; transform: translateY(10px); }
.entry-leave-to { opacity: 0; }
</style>
