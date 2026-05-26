<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const visible = ref(false)
onMounted(() => setTimeout(() => { visible.value = true }, 80))

function submit() {
    form.post('/admin/login', {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <Head title="Admin Login – Jordan Holton" />

    <div class="login-page">
        <div class="login-bg"></div>

        <div class="login-card" :class="{ visible }">
            <div class="login-header">
                <span class="login-logo">
                    <span class="lb">[</span>admin<span class="lb">]</span>
                </span>
                <p class="login-sub">
                    <span class="dollar">$</span> authenticate --user
                </p>
            </div>

            <!-- Error banner -->
            <div v-if="form.errors.email" class="error-banner">
                <span class="err-icon">✕</span> {{ form.errors.email }}
            </div>

            <form @submit.prevent="submit" class="login-form">
                <div class="field">
                    <label class="field-label" for="email">email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        autofocus
                        class="field-input"
                        :class="{ error: form.errors.email }"
                        placeholder="you@domain.com"
                    />
                </div>

                <div class="field">
                    <label class="field-label" for="password">password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        class="field-input"
                        placeholder="••••••••"
                    />
                </div>

                <label class="check-row">
                    <input v-model="form.remember" type="checkbox" class="check-box" />
                    <span class="check-label">remember this device</span>
                </label>

                <button type="submit" class="login-btn" :disabled="form.processing">
                    <span class="btn-dollar">$</span>
                    {{ form.processing ? 'authenticating...' : 'login' }}
                </button>
            </form>

            <a href="/" class="back-link">← back to site</a>
        </div>
    </div>
</template>

<style scoped>
.login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 24px;
}
.login-bg {
    position: fixed;
    inset: 0;
    background-image: radial-gradient(circle at 1px 1px, rgba(180,241,110,0.05) 1px, transparent 0);
    background-size: 32px 32px;
    pointer-events: none;
}

.login-card {
    width: 100%;
    max-width: 400px;
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 40px;
    position: relative;
    opacity: 0; transform: translateY(20px);
    transition: opacity 0.5s var(--ease), transform 0.5s var(--ease);
}
.login-card.visible { opacity: 1; transform: translateY(0); }

.login-header { text-align: center; margin-bottom: 32px; }
.login-logo {
    font-family: var(--font-mono);
    font-size: 18px;
    font-weight: 700;
    color: var(--text);
    display: block;
    margin-bottom: 8px;
}
.lb { color: var(--accent); }
.login-sub {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
}
.dollar { color: var(--accent); margin-right: 4px; }

/* Error */
.error-banner {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--red-dim);
    border: 1px solid rgba(241,110,110,0.2);
    border-radius: var(--radius);
    padding: 10px 14px;
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--red);
    margin-bottom: 20px;
}
.err-icon { font-size: 10px; }

/* Form */
.login-form { display: flex; flex-direction: column; gap: 20px; }

.field { display: flex; flex-direction: column; gap: 6px; }
.field-label {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-muted);
    letter-spacing: 0.05em;
}
.field-input {
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 10px 14px;
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--text);
    outline: none;
    width: 100%;
    transition: border-color var(--transition), box-shadow var(--transition);
}
.field-input::placeholder { color: var(--text-dim); }
.field-input:focus { border-color: var(--border-accent); box-shadow: 0 0 0 3px rgba(180,241,110,0.06); }
.field-input.error { border-color: rgba(241,110,110,0.4); }

.check-row {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}
.check-box { accent-color: var(--accent); }
.check-label {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
}

.login-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: var(--accent);
    color: #0a0a0a;
    font-family: var(--font-mono);
    font-size: 13px;
    font-weight: 500;
    border: none;
    border-radius: var(--radius);
    padding: 12px;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition);
    margin-top: 4px;
}
.login-btn:hover:not(:disabled) { background: #c8f890; transform: translateY(-1px); }
.login-btn:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-dollar { opacity: 0.6; font-weight: 700; }

.back-link {
    display: block;
    text-align: center;
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-dim);
    margin-top: 24px;
    transition: color var(--transition);
}
.back-link:hover { color: var(--text-muted); }
</style>
