<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

interface Moment {
    id: number
    title: string
    date: string
    body: string
    category: string
    published: boolean
}

defineProps<{ moments: Moment[] }>()

const page = usePage()
const flash = computed(() => (page.props as any).flash as { success?: string; error?: string })
const auth  = computed(() => (page.props as any).auth as { user: { name: string; email: string } })

const showFlash = ref(true)

function deleteMoment(id: number, title: string) {
    if (!confirm(`Delete "${title}"?`)) return
    router.delete(`/admin/moments/${id}`)
}

function logout() {
    router.post('/admin/logout')
}

function catClass(cat: string): string {
    return cat
}
</script>

<template>
    <Head title="Admin – Jordan Holton" />

    <div class="admin-page">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <span class="lb">[</span>admin<span class="lb">]</span>
            </div>
            <nav class="sidebar-nav">
                <a href="/admin" class="nav-item active">
                    <span class="nav-icon">▸</span> moments
                </a>
                <a href="/" class="nav-item" target="_blank">
                    <span class="nav-icon">⬡</span> view site
                </a>
            </nav>
            <div class="sidebar-user">
                <div class="user-name">{{ auth.user?.name }}</div>
                <div class="user-email">{{ auth.user?.email }}</div>
                <button class="logout-btn" @click="logout">
                    <span>$</span> logout
                </button>
            </div>
        </aside>

        <!-- Main -->
        <main class="admin-main">
            <div class="main-header">
                <div>
                    <p class="main-eyebrow"><span class="dollar">$</span> ls ./moments</p>
                    <h1 class="main-title">Moments</h1>
                </div>
                <a href="/admin/moments/create" class="create-btn">
                    <span class="btn-dollar">$</span> new moment
                </a>
            </div>

            <!-- Flash -->
            <transition name="fade">
                <div
                    v-if="flash.success && showFlash"
                    class="flash success"
                    @click="showFlash = false"
                >
                    <span class="flash-icon">✓</span> {{ flash.success }}
                    <button class="flash-close">✕</button>
                </div>
            </transition>

            <!-- Table -->
            <div class="table-wrap">
                <div class="table-header">
                    <span class="th">date</span>
                    <span class="th">title</span>
                    <span class="th">category</span>
                    <span class="th">status</span>
                    <span class="th th-actions">actions</span>
                </div>

                <div v-if="moments.length === 0" class="empty-state">
                    <span class="empty-prompt">$</span>
                    No moments yet —
                    <a href="/admin/moments/create" class="empty-link">add the first one</a>
                </div>

                <div
                    v-for="moment in moments"
                    :key="moment.id"
                    class="table-row"
                >
                    <span class="td td-date">{{ moment.date }}</span>
                    <span class="td td-title">{{ moment.title }}</span>
                    <span class="td">
                        <span class="cat-badge" :class="catClass(moment.category)">{{ moment.category }}</span>
                    </span>
                    <span class="td">
                        <span class="pub-badge" :class="{ published: moment.published, draft: !moment.published }">
                            {{ moment.published ? 'published' : 'draft' }}
                        </span>
                    </span>
                    <span class="td td-actions">
                        <a :href="`/admin/moments/${moment.id}/edit`" class="action-btn edit">edit</a>
                        <button class="action-btn delete" @click="deleteMoment(moment.id, moment.title)">delete</button>
                    </span>
                </div>
            </div>

            <p class="row-count">{{ moments.length }} moment{{ moments.length !== 1 ? 's' : '' }} total</p>
        </main>
    </div>
</template>

<style scoped>
.admin-page {
    display: grid;
    grid-template-columns: 220px 1fr;
    min-height: 100vh;
    background: var(--bg);
}

/* Sidebar */
.sidebar {
    background: var(--bg-surface);
    border-right: 1px solid var(--border);
    padding: 28px 20px;
    display: flex;
    flex-direction: column;
    gap: 40px;
    position: sticky;
    top: 0;
    height: 100vh;
}
.sidebar-logo {
    font-family: var(--font-mono);
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
}
.lb { color: var(--accent); }

.sidebar-nav { display: flex; flex-direction: column; gap: 4px; }
.nav-item {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
    padding: 8px 12px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    gap: 8px;
    border: 1px solid transparent;
    transition: color var(--transition), background var(--transition), border-color var(--transition);
}
.nav-item:hover { color: var(--text); background: var(--bg-elevated); }
.nav-item.active { color: var(--accent); background: var(--accent-dim); border-color: var(--border-accent); }
.nav-icon { font-size: 10px; }

.sidebar-user { margin-top: auto; }
.user-name { font-family: var(--font-mono); font-size: 13px; color: var(--text-strong); margin-bottom: 2px; }
.user-email { font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); margin-bottom: 12px; word-break: break-all; }
.logout-btn {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-muted);
    background: none;
    border: 1px solid var(--border);
    padding: 6px 12px;
    border-radius: var(--radius);
    cursor: pointer;
    transition: color var(--transition), border-color var(--transition);
    width: 100%;
}
.logout-btn span { color: var(--accent); }
.logout-btn:hover { color: var(--text); border-color: var(--border-hover); }

/* Main */
.admin-main { padding: 48px 56px; overflow-y: auto; }

.main-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 20px;
}
.main-eyebrow {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 6px;
}
.dollar { color: var(--accent); margin-right: 4px; }
.main-title {
    font-family: var(--font-mono);
    font-size: 32px;
    font-weight: 700;
    color: var(--text-strong);
}

.create-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-mono);
    font-size: 13px;
    font-weight: 500;
    color: var(--bg);
    background: var(--accent);
    padding: 10px 20px;
    border-radius: var(--radius);
    transition: background var(--transition), transform var(--transition);
}
.create-btn:hover { background: #c8f890; transform: translateY(-1px); }
.btn-dollar { opacity: 0.6; font-weight: 700; }

/* Flash */
.flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--radius);
    font-family: var(--font-mono);
    font-size: 12px;
    margin-bottom: 24px;
    cursor: pointer;
}
.flash.success { background: var(--accent-dim); border: 1px solid var(--border-accent); color: var(--accent); }
.flash-icon { font-size: 10px; }
.flash-close { margin-left: auto; background: none; border: none; color: inherit; cursor: pointer; opacity: 0.6; font-family: inherit; }

/* Table */
.table-wrap {
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 16px;
}
.table-header, .table-row {
    display: grid;
    grid-template-columns: 110px 1fr 130px 100px 160px;
    gap: 0;
}
.table-header {
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
}
.th {
    font-family: var(--font-mono);
    font-size: 10px;
    color: var(--text-muted);
    padding: 10px 16px;
    letter-spacing: 0.06em;
}
.table-row {
    border-bottom: 1px solid var(--border);
    transition: background var(--transition);
    align-items: center;
}
.table-row:last-child { border-bottom: none; }
.table-row:hover { background: var(--bg-elevated); }
.td {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text);
    padding: 14px 16px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.td-date { color: var(--text-muted); }
.td-title { color: var(--text-strong); }

.cat-badge {
    font-size: 10px;
    padding: 2px 8px;
    border-radius: 3px;
}
.cat-badge.personal    { background: rgba(110,180,241,0.1); color: var(--blue); border: 1px solid rgba(110,180,241,0.2); }
.cat-badge.professional { background: var(--accent-dim); color: var(--accent); border: 1px solid var(--border-accent); }
.cat-badge.milestone   { background: rgba(241,196,110,0.1); color: var(--amber); border: 1px solid rgba(241,196,110,0.2); }

.pub-badge { font-size: 10px; padding: 2px 8px; border-radius: 3px; }
.pub-badge.published { background: var(--accent-dim); color: var(--accent); border: 1px solid var(--border-accent); }
.pub-badge.draft { background: var(--bg-elevated); color: var(--text-muted); border: 1px solid var(--border); }

.td-actions { display: flex; align-items: center; gap: 8px; }
.action-btn {
    font-family: var(--font-mono);
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 4px;
    border: 1px solid var(--border);
    cursor: pointer;
    background: none;
    transition: all var(--transition);
}
.action-btn.edit { color: var(--text-muted); }
.action-btn.edit:hover { color: var(--accent); border-color: var(--border-accent); background: var(--accent-dim); }
.action-btn.delete { color: var(--text-muted); }
.action-btn.delete:hover { color: var(--red); border-color: rgba(241,110,110,0.3); background: var(--red-dim); }

.empty-state {
    padding: 40px 24px;
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--text-muted);
    text-align: center;
}
.empty-prompt { color: var(--accent); margin-right: 6px; }
.empty-link { color: var(--accent); text-decoration: underline; }

.row-count { font-family: var(--font-mono); font-size: 11px; color: var(--text-dim); }

.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

@media (max-width: 900px) {
    .admin-page { grid-template-columns: 1fr; }
    .sidebar { height: auto; position: relative; flex-direction: row; flex-wrap: wrap; }
    .admin-main { padding: 32px 24px; }
    .table-header, .table-row { grid-template-columns: 100px 1fr 120px 90px; }
    .th-actions, .td-actions { display: none; }
}
</style>
