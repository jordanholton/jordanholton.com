<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import TopNav from '@/components/TopNav.vue'
import SiteFooter from '@/components/SiteFooter.vue'
import { ref, onMounted } from 'vue'

const visible = ref(false)
const termVisible = ref(false)

onMounted(() => {
    setTimeout(() => { visible.value = true }, 80)
    setTimeout(() => { termVisible.value = true }, 300)
})
</script>

<template>
    <Head title="IT Architect & Entrepreneur" />
    <TopNav />

    <div class="page-wrap">
        <main>
            <!-- ── Hero ──────────────────────────────────────────── -->
            <section class="hero">
                <div class="hero-bg"></div>
                <div class="container hero-grid">
                    <!-- Left -->
                    <div class="hero-left" :class="{ visible }">
                        <p class="hero-eyebrow">
                            <span class="ey-slash">// </span>it architect && entrepreneur
                        </p>
                        <h1 class="hero-name">
                            Jordan<br />Holton<span class="name-dot">.</span>
                        </h1>
                        <p class="hero-sub">Automation-Focused</p>
                        <p class="hero-bio">
                            Building resilient distributed systems with automation at the
                            core. I bridge infrastructure and product — from IaC to CI/CD
                            to cloud-native architecture at scale.
                        </p>
                        <div class="hero-ctas">
                            <a href="/work" class="btn-primary">
                                <span class="btn-dollar">$</span> view --work
                            </a>
                            <a href="/about" class="btn-ghost">./about.md</a>
                        </div>
                        <div class="hero-status">
                            <span class="status-dot"></span>
                            available &nbsp;·&nbsp; remote-first
                        </div>
                    </div>

                    <!-- Terminal widget -->
                    <div class="hero-term" :class="{ visible: termVisible }">
                        <div class="term-chrome">
                            <span class="dot dot-r"></span>
                            <span class="dot dot-y"></span>
                            <span class="dot dot-g"></span>
                            <span class="term-title">jordan@holton ~ sys</span>
                        </div>
                        <div class="term-body">
                            <div class="tl">
                                <span class="tp">$</span>
                                <span class="tc"> whoami</span>
                            </div>
                            <div class="tl out">
                                <span class="tk">name</span><span class="ts"> · </span><span class="tv">jordan holton</span>
                            </div>
                            <div class="tl out">
                                <span class="tk">role</span><span class="ts"> · </span><span class="tv">it architect / entrepreneur</span>
                            </div>
                            <div class="tl out">
                                <span class="tk">type</span><span class="ts"> · </span><span class="tv">automation-focused</span>
                            </div>

                            <div class="tl mt"></div>

                            <div class="tl">
                                <span class="tp">$</span>
                                <span class="tc"> stack --primary</span>
                            </div>
                            <div class="tl out">
                                <span class="ta">php</span><span class="ts"> · </span><span class="ta">typescript</span><span class="ts"> · </span><span class="ta">python</span>
                            </div>
                            <div class="tl out">
                                <span class="ta">terraform</span><span class="ts"> · </span><span class="ta">k8s</span><span class="ts"> · </span><span class="ta">aws</span>
                            </div>

                            <div class="tl mt"></div>

                            <div class="tl">
                                <span class="tp">$</span>
                                <span class="tc"> status --verbose</span>
                            </div>
                            <div class="tl out">
                                <span class="status-sym">●</span>
                                <span class="tv"> available &nbsp;· &nbsp;remote</span>
                            </div>
                            <div class="tl out">
                                <span class="tk">open-to</span><span class="ts"> · </span><span class="tv">full-time / contract</span>
                            </div>
                            <div class="tl mt"></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ── Capabilities ───────────────────────────────────── -->
            <section class="caps-section">
                <div class="container">
                    <p class="section-label"><span class="sl">// </span>capabilities</p>
                    <div class="caps-grid">
                        <div class="cap-card">
                            <div class="cap-icon">⬡</div>
                            <h3 class="cap-title">Systems Architecture</h3>
                            <p class="cap-desc">Designing scalable, fault-tolerant distributed systems. Microservices, event-driven pipelines, and API platforms with resilience from day one.</p>
                        </div>
                        <div class="cap-card">
                            <div class="cap-icon">⬡</div>
                            <h3 class="cap-title">Infrastructure as Code</h3>
                            <p class="cap-desc">Terraform, Kubernetes, Ansible — cloud infrastructure as reproducible, version-controlled, self-documenting code. No more snowflakes.</p>
                        </div>
                        <div class="cap-card">
                            <div class="cap-icon">⬡</div>
                            <h3 class="cap-title">Automation Pipelines</h3>
                            <p class="cap-desc">CI/CD workflows, deployment pipelines, and process automation that eliminate toil, reduce risk, and increase delivery velocity.</p>
                        </div>
                        <div class="cap-card">
                            <div class="cap-icon">⬡</div>
                            <h3 class="cap-title">Cloud Native</h3>
                            <p class="cap-desc">AWS and GCP architecture — ECS, EKS, Lambda, managed databases, CDN layers, and cost-optimized multi-environment setups.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <SiteFooter />
    </div>
</template>

<style scoped>
/* ── Hero layout ─────────────────────────────────────────────── */
.hero {
    position: relative;
    min-height: calc(100vh - var(--nav-height));
    display: flex;
    align-items: center;
    overflow: hidden;
    padding: 80px 0;
}

.hero-bg {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 1px 1px, var(--hero-dot) 1px, transparent 0);
    background-size: 36px 36px;
    pointer-events: none;
}

.hero-grid {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 64px;
    align-items: center;
}

/* ── Left content ─────────────────────────────────────────────── */
.hero-left {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.6s var(--ease), transform 0.6s var(--ease);
}
.hero-left.visible { opacity: 1; transform: translateY(0); }

.hero-eyebrow {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
    letter-spacing: 0.1em;
    margin-bottom: 20px;
}
.ey-slash { color: var(--accent); }

.hero-name {
    font-family: var(--font-mono);
    font-size: clamp(52px, 7vw, 88px);
    font-weight: 700;
    line-height: 1.0;
    color: var(--text-strong);
    letter-spacing: -0.02em;
    margin-bottom: 12px;
}
.name-dot { color: var(--accent); }

.hero-sub {
    font-family: var(--font-mono);
    font-size: 14px;
    color: var(--accent);
    letter-spacing: 0.06em;
    margin-bottom: 24px;
}

.hero-bio {
    font-size: 17px;
    color: var(--text);
    line-height: 1.7;
    max-width: 520px;
    margin-bottom: 36px;
}

.hero-ctas {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 32px;
}

.btn-primary {
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
    transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
}
.btn-primary:hover {
    background: #c8f890;
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(180, 241, 110, 0.3);
}
.btn-dollar { opacity: 0.6; font-weight: 700; }

.btn-ghost {
    display: inline-flex;
    align-items: center;
    font-family: var(--font-mono);
    font-size: 13px;
    color: var(--text-muted);
    border: 1px solid var(--border);
    padding: 10px 20px;
    border-radius: var(--radius);
    transition: color var(--transition), border-color var(--transition), background var(--transition);
}
.btn-ghost:hover {
    color: var(--accent);
    border-color: var(--border-accent);
    background: var(--accent-dim);
}

.hero-status {
    font-family: var(--font-mono);
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 8px;
}
.status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--accent);
    box-shadow: 0 0 8px var(--accent-glow);
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 8px var(--accent-glow); }
    50% { opacity: 0.7; box-shadow: 0 0 16px var(--accent-glow); }
}

/* ── Terminal widget ─────────────────────────────────────────── */
.hero-term {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.6s var(--ease) 0.15s, transform 0.6s var(--ease) 0.15s;
    box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
}
.hero-term.visible { opacity: 1; transform: translateY(0); }

.term-chrome {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 12px 16px;
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
}
.dot { width: 11px; height: 11px; border-radius: 50%; }
.dot-r { background: #f16e6e; }
.dot-y { background: var(--amber); }
.dot-g { background: var(--accent); }
.term-title {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-muted);
    margin-left: 8px;
}

.term-body {
    padding: 20px 20px 16px;
}
.tl {
    font-family: var(--font-mono);
    font-size: 12.5px;
    line-height: 1.8;
    display: flex;
    align-items: baseline;
    gap: 0;
}
.tl.out { padding-left: 14px; }
.tl.mt { height: 8px; }
.tl.cursor-line { margin-top: 4px; }

.tp { color: var(--accent); font-weight: 700; margin-right: 4px; }
.tc { color: var(--text); }
.tk { color: var(--text-muted); min-width: 52px; }
.ts { color: var(--text-dim); margin: 0 2px; }
.tv { color: var(--text); }
.ta { color: var(--accent); }

.status-sym { color: var(--accent); font-size: 10px; }

.blink {
    color: var(--accent);
    animation: blink 1.1s step-end infinite;
    margin-left: 4px;
}
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}

/* ── Capabilities section ─────────────────────────────────────── */
.caps-section {
    padding: 96px 0;
    border-top: 1px solid var(--border);
}

.caps-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2px;
}

.cap-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    padding: 32px 28px;
    transition: border-color var(--transition), background var(--transition);
}
.cap-card:hover {
    border-color: var(--border-accent);
    background: var(--bg-elevated);
}

.cap-icon {
    font-size: 20px;
    color: var(--accent);
    margin-bottom: 16px;
    opacity: 0.8;
}

.cap-title {
    font-family: var(--font-mono);
    font-size: 13px;
    font-weight: 500;
    color: var(--text-strong);
    margin-bottom: 12px;
    letter-spacing: 0.02em;
}

.cap-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.7;
}

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 900px) {
    .hero-grid {
        grid-template-columns: 1fr;
        gap: 48px;
    }
    .hero-term { max-width: 480px; }
    .caps-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 560px) {
    .caps-grid { grid-template-columns: 1fr; }
    .hero-name { font-size: 52px; }
}
</style>
