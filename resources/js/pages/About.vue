<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import TopNav from '@/components/TopNav.vue'
import { ref, onMounted } from 'vue'

const visible = ref(false)
onMounted(() => setTimeout(() => { visible.value = true }, 80))
</script>

<template>
    <Head title="About – Jordan Holton" />
    <TopNav />

    <div class="page-wrap">
        <main>
            <section class="about-section">
                <div class="container">
                    <!-- Header -->
                    <div class="page-header" :class="{ visible }">
                        <p class="section-label"><span class="sl">$</span> cat about.md</p>
                        <h1 class="page-title">About</h1>
                    </div>

                    <!-- Main grid -->
                    <div class="about-grid" :class="{ visible }">
                        <!-- Bio -->
                        <div class="bio-col">
                            <div class="bio-block">
                                <p class="bio-text">
                                    I'm a systems architect and automation engineer with over a decade of
                                    experience building distributed systems, cloud infrastructure, and the
                                    automation pipelines that hold them together.
                                </p>
                                <p class="bio-text">
                                    My work lives at the intersection of infrastructure and product — I care
                                    as much about the developer experience as I do about uptime. Automation
                                    isn't just a tool for me; it's a philosophy: if you're doing it twice,
                                    it should be a pipeline.
                                </p>
                                <p class="bio-text">
                                    Outside of work I'm usually on a trail, experimenting with home
                                    automation, or tinkering with something that probably didn't need to
                                    be automated but now is.
                                </p>
                            </div>

                            <!-- Values -->
                            <div class="values-block">
                                <p class="block-label"><span class="sl">// </span>principles</p>
                                <div class="values-list">
                                    <div class="value-item">
                                        <span class="val-num">01</span>
                                        <div>
                                            <p class="val-title">Systems over heroics</p>
                                            <p class="val-desc">Good processes beat individual brilliance. Build systems that work without you in the room.</p>
                                        </div>
                                    </div>
                                    <div class="value-item">
                                        <span class="val-num">02</span>
                                        <div>
                                            <p class="val-title">Automate the toil</p>
                                            <p class="val-desc">If a human is doing it repeatedly, a computer should be doing it. Engineer the work out of the work.</p>
                                        </div>
                                    </div>
                                    <div class="value-item">
                                        <span class="val-num">03</span>
                                        <div>
                                            <p class="val-title">Simplicity scales</p>
                                            <p class="val-desc">The best architecture is the simplest one that meets the real requirements — not the imagined ones.</p>
                                        </div>
                                    </div>
                                    <div class="value-item">
                                        <span class="val-num">04</span>
                                        <div>
                                            <p class="val-title">Ship, observe, iterate</p>
                                            <p class="val-desc">Observability is not optional. You can't fix what you can't measure. Instrument everything.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats sidebar -->
                        <div class="stats-col">
                            <div class="stats-card">
                                <p class="block-label"><span class="sl">// </span>quick.facts</p>
                                <div class="stat-rows">
                                    <div class="stat-row">
                                        <span class="stat-key">role</span>
                                        <span class="stat-val">Systems Architect</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">type</span>
                                        <span class="stat-val">Automation Engineer</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">experience</span>
                                        <span class="stat-val accent">10+ years</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">location</span>
                                        <span class="stat-val">Remote-first</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">available</span>
                                        <span class="stat-val accent">● yes</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">focus</span>
                                        <span class="stat-val">dist. systems</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">cloud</span>
                                        <span class="stat-val">AWS, GCP</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">iac</span>
                                        <span class="stat-val">Terraform</span>
                                    </div>
                                    <div class="stat-row">
                                        <span class="stat-key">coffee</span>
                                        <span class="stat-val">black, always</span>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-card">
                                <p class="block-label"><span class="sl">$ </span>contact --email</p>
                                <a href="mailto:jordan@jordanholton.com" class="contact-link">
                                    jordan@jordanholton.com
                                </a>
                                <p class="contact-sub">Open to full-time and contract roles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                <span class="footer-logo"><span class="br">[</span>jordan.holton<span class="br">]</span></span>
                <span class="footer-built">// built with laravel · vue · inertia</span>
                <a href="mailto:jordan@jordanholton.com" class="footer-email" style="margin-left:auto;">jordan@jordanholton.com</a>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.about-section { padding: 80px 0 96px; }

.page-header {
    opacity: 0;
    transform: translateY(16px);
    transition: opacity 0.5s var(--ease), transform 0.5s var(--ease);
    margin-bottom: 64px;
}
.page-header.visible { opacity: 1; transform: translateY(0); }

.page-title {
    font-family: var(--font-mono);
    font-size: clamp(40px, 6vw, 72px);
    font-weight: 700;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.05;
}

/* ── About grid ──────────────────────────────────────────────── */
.about-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 64px;
    align-items: start;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.55s var(--ease) 0.1s, transform 0.55s var(--ease) 0.1s;
}
.about-grid.visible { opacity: 1; transform: translateY(0); }

/* Bio */
.bio-text {
    font-size: 17px;
    color: var(--text);
    line-height: 1.75;
    margin-bottom: 20px;
}

.values-block { margin-top: 56px; }
.block-label {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
    letter-spacing: 0.08em;
    margin-bottom: 28px;
}

.values-list { display: flex; flex-direction: column; gap: 28px; }
.value-item {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}
.val-num {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--accent);
    opacity: 0.6;
    min-width: 24px;
    padding-top: 3px;
}
.val-title {
    font-family: var(--font-mono);
    font-size: 13px;
    color: #fff;
    margin-bottom: 6px;
}
.val-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.65;
}

/* Stats sidebar */
.stats-col { display: flex; flex-direction: column; gap: 16px; }

.stats-card, .contact-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
}

.stat-rows { display: flex; flex-direction: column; }
.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    gap: 12px;
    padding: 8px 0;
    border-bottom: 1px solid var(--border);
    font-family: var(--font-mono);
    font-size: 12px;
}
.stat-row:last-child { border-bottom: none; }
.stat-key { color: var(--text-muted); }
.stat-val { color: var(--text); text-align: right; }
.stat-val.accent { color: var(--accent); }

.contact-link {
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--accent);
    display: block;
    margin-top: 12px;
    margin-bottom: 8px;
    transition: opacity var(--transition);
}
.contact-link:hover { opacity: 0.75; }
.contact-sub {
    font-size: 12px;
    color: var(--text-muted);
}

/* Responsive */
@media (max-width: 860px) {
    .about-grid { grid-template-columns: 1fr; }
    .stats-col { flex-direction: row; flex-wrap: wrap; }
    .stats-card, .contact-card { flex: 1; min-width: 240px; }
}
</style>
