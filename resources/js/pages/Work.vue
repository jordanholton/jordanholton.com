<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import TopNav from '@/components/TopNav.vue'
import { ref, onMounted } from 'vue'

const visible = ref(false)
onMounted(() => setTimeout(() => { visible.value = true }, 80))

const projects = [
    {
        name: 'infra-core',
        tagline: 'Multi-cloud IaC Platform',
        desc: 'A production-tested Terraform module library for AWS and GCP. Encapsulates VPC, ECS clusters, RDS, Redis, and ALB configuration with opinionated defaults and zero drift.',
        tags: ['terraform', 'aws', 'gcp', 'github-actions'],
        status: 'production',
        year: '2024',
    },
    {
        name: 'k8s-automaton',
        tagline: 'Kubernetes Deployment Operator',
        desc: 'A custom K8s operator that manages canary deployments, automatic rollback on error-rate threshold breach, and GitOps-driven configuration sync across clusters.',
        tags: ['go', 'kubernetes', 'prometheus', 'argocd'],
        status: 'production',
        year: '2024',
    },
    {
        name: 'pipeline-forge',
        tagline: 'Unified CI/CD Orchestration Layer',
        desc: 'Abstraction layer over GitHub Actions and GitLab CI that provides a single configuration format, reusable pipeline templates, and centralized secrets management.',
        tags: ['python', 'github-actions', 'gitlab-ci', 'vault'],
        status: 'open-source',
        year: '2023',
    },
    {
        name: 'observa',
        tagline: 'Internal Observability Platform',
        desc: 'Centralized metrics, logs, and traces platform built on the OpenTelemetry stack. Includes automated alerting, SLO dashboards, and incident correlation.',
        tags: ['opentelemetry', 'prometheus', 'grafana', 'loki'],
        status: 'production',
        year: '2023',
    },
    {
        name: 'jordanholton.com',
        tagline: 'This Site',
        desc: 'A personal professional site built with Laravel, Inertia.js, and Vue 3. Dark terminal aesthetic, admin panel for the moments timeline, deployed on a single VPS.',
        tags: ['laravel', 'vue', 'inertia', 'tailwind'],
        status: 'shipped',
        year: '2026',
    },
    {
        name: 'data-relay',
        tagline: 'Real-time Event Streaming Service',
        desc: 'High-throughput event ingestion service processing 2M+ events/day. Kafka-backed with exactly-once semantics, schema registry, and consumer-group management.',
        tags: ['python', 'kafka', 'postgresql', 'redis'],
        status: 'production',
        year: '2022',
    },
]
</script>

<template>
    <Head title="Work – Jordan Holton" />
    <TopNav />

    <div class="page-wrap">
        <main>
            <section class="work-section">
                <div class="container">
                    <div class="page-header" :class="{ visible }">
                        <p class="section-label"><span class="sl">$ </span>ls --work ./projects</p>
                        <h1 class="page-title">Work</h1>
                        <p class="page-sub">Selected projects — production systems, open-source tooling, and personal builds.</p>
                    </div>

                    <div class="projects-grid" :class="{ visible }">
                        <div v-for="(p, i) in projects" :key="p.name" class="project-card" :style="{ transitionDelay: `${i * 60}ms` }">
                            <div class="card-chrome">
                                <span class="dot dot-r"></span>
                                <span class="dot dot-y"></span>
                                <span class="dot dot-g"></span>
                                <span class="card-name">~/projects/{{ p.name }}</span>
                                <span class="card-year">{{ p.year }}</span>
                            </div>
                            <div class="card-body">
                                <div class="card-top">
                                    <h3 class="card-title">{{ p.tagline }}</h3>
                                    <span class="card-status" :class="p.status">{{ p.status }}</span>
                                </div>
                                <p class="card-desc">{{ p.desc }}</p>
                                <div class="card-tags">
                                    <span v-for="tag in p.tags" :key="tag" class="tag">{{ tag }}</span>
                                </div>
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
.work-section { padding: 80px 0 96px; }

.page-header {
    opacity: 0; transform: translateY(16px);
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
    margin-bottom: 16px;
}
.page-sub { font-size: 16px; color: var(--text-muted); max-width: 500px; }

/* Grid */
.projects-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2px;
    opacity: 0; transform: translateY(20px);
    transition: opacity 0.55s var(--ease) 0.1s, transform 0.55s var(--ease) 0.1s;
}
.projects-grid.visible { opacity: 1; transform: translateY(0); }

/* Card */
.project-card {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: border-color var(--transition), background var(--transition);
}
.project-card:hover { border-color: var(--border-accent); background: var(--bg-elevated); }

.card-chrome {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 10px 16px;
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
}
.dot { width: 10px; height: 10px; border-radius: 50%; }
.dot-r { background: #f16e6e; }
.dot-y { background: #f1c46e; }
.dot-g { background: var(--accent); }
.card-name {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-muted);
    margin-left: 6px;
    flex: 1;
}
.card-year {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--text-dim);
}

.card-body { padding: 28px; }

.card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}
.card-title {
    font-family: var(--font-mono);
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    flex: 1;
}
.card-status {
    font-family: var(--font-mono);
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 4px;
    flex-shrink: 0;
    margin-top: 2px;
}
.card-status.production { background: var(--accent-dim); color: var(--accent); border: 1px solid var(--border-accent); }
.card-status.open-source { background: rgba(110, 180, 241, 0.1); color: var(--blue); border: 1px solid rgba(110,180,241,0.2); }
.card-status.shipped { background: rgba(180, 241, 110, 0.08); color: var(--accent); border: 1px solid rgba(180,241,110,0.15); }

.card-desc {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.7;
    margin-bottom: 20px;
}
.card-tags { display: flex; flex-wrap: wrap; gap: 6px; }
.tag {
    font-family: var(--font-mono);
    font-size: 10px;
    color: var(--text-muted);
    border: 1px solid var(--border);
    padding: 3px 8px;
    border-radius: 4px;
    transition: color var(--transition), border-color var(--transition);
}
.project-card:hover .tag { color: var(--text); border-color: rgba(255,255,255,0.14); }

/* Responsive */
@media (max-width: 768px) { .projects-grid { grid-template-columns: 1fr; } }
</style>
