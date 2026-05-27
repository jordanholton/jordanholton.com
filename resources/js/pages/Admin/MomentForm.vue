<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'

interface Moment {
    id?: number
    title: string
    date: string
    body: string
    category: 'personal' | 'professional' | 'milestone'
    published: boolean
}

const props = defineProps<{ moment?: Moment }>()

const isEdit = !!props.moment?.id

const form = useForm({
    title:     props.moment?.title     ?? '',
    date:      props.moment?.date      ?? new Date().toISOString().slice(0, 10),
    body:      props.moment?.body      ?? '',
    category:  props.moment?.category  ?? 'personal',
    published: props.moment?.published ?? true,
})

function submit() {
    if (isEdit) {
        form.put(`/admin/moments/${props.moment!.id}`)
    } else {
        form.post('/admin/moments')
    }
}
</script>

<template>
    <Head :title="`${isEdit ? 'Edit' : 'New'} Moment – Admin`" />

    <div class="admin-page">
        <!-- Sidebar (same as Dashboard) -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <span class="lb">[</span>admin<span class="lb">]</span>
            </div>
            <nav class="sidebar-nav">
                <a href="/admin" class="nav-item">
                    <span class="nav-icon">▸</span> moments
                </a>
                <a href="/" class="nav-item" target="_blank">
                    <span class="nav-icon">⬡</span> view site
                </a>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="form-header">
                <p class="form-eyebrow">
                    <span class="dollar">$</span>
                    {{ isEdit ? `vim ./moments/${moment!.id}` : 'touch ./moments/new' }}
                </p>
                <h1 class="form-title">{{ isEdit ? 'Edit Moment' : 'New Moment' }}</h1>
            </div>

            <form @submit.prevent="submit" class="moment-form">
                <!-- Row: date + category -->
                <div class="form-row">
                    <div class="field">
                        <label class="field-label" for="date">date</label>
                        <input
                            id="date"
                            v-model="form.date"
                            type="date"
                            class="field-input"
                            :class="{ error: form.errors.date }"
                        />
                        <p v-if="form.errors.date" class="field-error">{{ form.errors.date }}</p>
                    </div>

                    <div class="field">
                        <label class="field-label" for="category">category</label>
                        <select
                            id="category"
                            v-model="form.category"
                            class="field-input field-select"
                            :class="{ error: form.errors.category }"
                        >
                            <option value="personal">personal</option>
                            <option value="professional">professional</option>
                            <option value="milestone">milestone</option>
                        </select>
                        <p v-if="form.errors.category" class="field-error">{{ form.errors.category }}</p>
                    </div>
                </div>

                <!-- Title -->
                <div class="field">
                    <label class="field-label" for="title">title</label>
                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="field-input"
                        :class="{ error: form.errors.title }"
                        placeholder="What happened?"
                    />
                    <p v-if="form.errors.title" class="field-error">{{ form.errors.title }}</p>
                </div>

                <!-- Body -->
                <div class="field">
                    <label class="field-label" for="body">body</label>
                    <textarea
                        id="body"
                        v-model="form.body"
                        class="field-input field-textarea"
                        :class="{ error: form.errors.body }"
                        placeholder="Write about this moment..."
                        rows="6"
                    ></textarea>
                    <p v-if="form.errors.body" class="field-error">{{ form.errors.body }}</p>
                </div>

                <!-- Published toggle -->
                <label class="toggle-row">
                    <div class="toggle" :class="{ on: form.published }" @click="form.published = !form.published">
                        <div class="toggle-thumb"></div>
                    </div>
                    <div>
                        <span class="toggle-label">{{ form.published ? 'Published' : 'Draft' }}</span>
                        <span class="toggle-hint">{{ form.published ? 'Visible on the moments page' : 'Hidden from public view' }}</span>
                    </div>
                </label>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn" :disabled="form.processing">
                        <span class="btn-dollar">$</span>
                        {{ form.processing ? 'saving...' : (isEdit ? 'save changes' : 'create moment') }}
                    </button>
                    <a href="/admin" class="cancel-btn">cancel</a>
                </div>
            </form>
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

/* Sidebar (shared style) */
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
.nav-icon { font-size: 10px; }

/* Main */
.admin-main { padding: 48px 56px; max-width: 720px; }

.form-eyebrow {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 6px;
}
.dollar { color: var(--accent); margin-right: 4px; }
.form-title {
    font-family: var(--font-mono);
    font-size: 32px;
    font-weight: 700;
    color: var(--text-strong);
    margin-bottom: 48px;
}

/* Form */
.moment-form { display: flex; flex-direction: column; gap: 28px; }

.form-row { display: grid; grid-template-columns: 180px 1fr; gap: 20px; }

.field { display: flex; flex-direction: column; gap: 6px; }
.field-label {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-muted);
    letter-spacing: 0.05em;
}
.field-input {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 10px 14px;
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--text);
    outline: none;
    width: 100%;
    transition: border-color var(--transition), box-shadow var(--transition);
    appearance: none;
}
.field-input::placeholder { color: var(--text-dim); }
.field-input:focus { border-color: var(--border-accent); box-shadow: 0 0 0 3px rgba(180,241,110,0.06); }
.field-input.error { border-color: rgba(241,110,110,0.4); }

.field-select { cursor: pointer; }
.field-textarea { resize: vertical; min-height: 160px; font-size: 14px; line-height: 1.7; }

.field-error {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--red);
}

/* Toggle */
.toggle-row {
    display: flex;
    align-items: center;
    gap: 14px;
    cursor: pointer;
    padding: 16px;
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
}
.toggle {
    width: 40px;
    height: 22px;
    border-radius: 11px;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    padding: 2px;
    transition: background var(--transition), border-color var(--transition);
    flex-shrink: 0;
}
.toggle.on { background: var(--accent); border-color: var(--accent); }
.toggle-thumb {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--text-muted);
    transition: transform var(--transition), background var(--transition);
}
.toggle.on .toggle-thumb { transform: translateX(18px); background: #0a0a0a; }
.toggle-label {
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--text-strong);
    display: block;
    margin-bottom: 2px;
}
.toggle-hint {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-muted);
}

/* Actions */
.form-actions { display: flex; align-items: center; gap: 12px; padding-top: 8px; }
.submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-mono);
    font-size: 13px;
    font-weight: 500;
    color: var(--bg);
    background: var(--accent);
    border: none;
    padding: 11px 24px;
    border-radius: var(--radius);
    cursor: pointer;
    transition: background var(--transition), transform var(--transition);
}
.submit-btn:hover:not(:disabled) { background: #c8f890; transform: translateY(-1px); }
.submit-btn:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-dollar { opacity: 0.6; font-weight: 700; }
.cancel-btn {
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--text-muted);
    padding: 11px 16px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    transition: color var(--transition), border-color var(--transition);
}
.cancel-btn:hover { color: var(--text); border-color: var(--border-hover); }

@media (max-width: 768px) {
    .admin-page { grid-template-columns: 1fr; }
    .sidebar { height: auto; position: relative; }
    .admin-main { padding: 32px 24px; }
    .form-row { grid-template-columns: 1fr; }
}
</style>
