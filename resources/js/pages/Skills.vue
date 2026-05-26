<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import TopNav from '@/components/TopNav.vue'
import { ref, onMounted } from 'vue'

const visible = ref(false)
const barsAnimated = ref(false)

onMounted(() => {
    setTimeout(() => { visible.value = true }, 80)
    setTimeout(() => { barsAnimated.value = true }, 400)
})

const skillGroups = [
    {
        id: 'infra',
        label: '// infrastructure & cloud',
        skills: [
            { name: 'AWS',        level: 90, tags: ['EC2', 'ECS', 'EKS', 'Lambda', 'RDS', 'S3'] },
            { name: 'Terraform',  level: 88, tags: ['modules', 'state', 'workspaces'] },
            { name: 'Kubernetes', level: 82, tags: ['operators', 'helm', 'CKA certified'] },
            { name: 'Docker',     level: 92, tags: ['multi-stage', 'compose', 'registry'] },
            { name: 'GCP',        level: 70, tags: ['GKE', 'Cloud Run', 'Pub/Sub'] },
            { name: 'Ansible',    level: 75, tags: ['roles', 'vault', 'playbooks'] },
        ],
    },
    {
        id: 'lang',
        label: '// languages & frameworks',
        skills: [
            { name: 'PHP / Laravel',   level: 92, tags: ['Inertia', 'Octane', 'Queues'] },
            { name: 'TypeScript / Vue', level: 85, tags: ['Vue 3', 'Composition API'] },
            { name: 'Python',           level: 80, tags: ['FastAPI', 'Celery', 'scripts'] },
            { name: 'Bash / Shell',     level: 88, tags: ['scripting', 'automation'] },
            { name: 'Go',               level: 60, tags: ['CLI tools', 'K8s operators'] },
            { name: 'SQL',              level: 85, tags: ['PostgreSQL', 'MySQL', 'query opt.'] },
        ],
    },
    {
        id: 'cicd',
        label: '// automation & delivery',
        skills: [
            { name: 'GitHub Actions',    level: 90, tags: ['reusable workflows', 'OIDC'] },
            { name: 'GitLab CI',         level: 82, tags: ['runners', 'environments'] },
            { name: 'ArgoCD',            level: 75, tags: ['GitOps', 'app-of-apps'] },
            { name: 'Vault (HashiCorp)', level: 78, tags: ['dynamic secrets', 'PKI'] },
            { name: 'Prometheus',        level: 80, tags: ['alertmanager', 'recording rules'] },
            { name: 'OpenTelemetry',     level: 72, tags: ['traces', 'metrics', 'logs'] },
        ],
    },
    {
        id: 'data',
        label: '// data & messaging',
        skills: [
            { name: 'PostgreSQL', level: 86, tags: ['replication', 'partitioning'] },
            { name: 'Redis',      level: 84, tags: ['pub/sub', 'streams', 'clustering'] },
            { name: 'Kafka',      level: 76, tags: ['streams', 'schema registry'] },
            { name: 'MongoDB',    level: 68, tags: ['aggregation', 'Atlas'] },
            { name: 'Elasticsearch', level: 70, tags: ['indexing', 'search', 'APM'] },
        ],
    },
]

function barWidth(level: number): string {
    return barsAnimated.value ? `${level}%` : '0%'
}
</script>

<template>
    <Head title="Skills – Jordan Holton" />
    <TopNav />

    <div class="page-wrap">
        <main>
            <section class="skills-section">
                <div class="container">
                    <div class="page-header" :class="{ visible }">
                        <p class="section-label"><span class="sl">$ </span>sys --capabilities --verbose</p>
                        <h1 class="page-title">Skills</h1>
                        <p class="page-sub">10+ years of production experience across infrastructure, automation, and full-stack development.</p>
                    </div>

                    <div class="skills-content" :class="{ visible }">
                        <div
                            v-for="(group, gi) in skillGroups"
                            :key="group.id"
                            class="skill-group"
                            :style="{ transitionDelay: `${gi * 80}ms` }"
                        >
                            <p class="group-label">{{ group.label }}</p>
                            <div class="skill-rows">
                                <div v-for="skill in group.skills" :key="skill.name" class="skill-row">
                                    <div class="skill-meta">
                                        <span class="skill-name">{{ skill.name }}</span>
                                        <div class="skill-tags">
                                            <span v-for="tag in skill.tags" :key="tag" class="stag">{{ tag }}</span>
                                        </div>
                                    </div>
                                    <div class="bar-track">
                                        <div
                                            class="bar-fill"
                                            :style="{ width: barWidth(skill.level) }"
                                        ></div>
                                        <span class="bar-pct">{{ skill.level }}%</span>
                                    </div>
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
.skills-section { padding: 80px 0 96px; }

.page-header {
    opacity: 0; transform: translateY(16px);
    transition: opacity 0.5s var(--ease), transform 0.5s var(--ease);
    margin-bottom: 64px;
}
.page-header.visible { opacity: 1; transform: translateY(0); }

.page-title {
    font-family: var(--font-mono);
    font-size: clamp(40px, 6vw, 72px);
    font-weight: 700; color: #fff;
    letter-spacing: -0.02em; line-height: 1.05;
    margin-bottom: 16px;
}
.page-sub { font-size: 16px; color: var(--text-muted); max-width: 520px; }

/* Skills layout */
.skills-content {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 48px 80px;
    opacity: 0; transform: translateY(20px);
    transition: opacity 0.55s var(--ease) 0.1s, transform 0.55s var(--ease) 0.1s;
}
.skills-content.visible { opacity: 1; transform: translateY(0); }

.skill-group { transition: opacity 0.4s var(--ease), transform 0.4s var(--ease); }

.group-label {
    font-family: var(--font-mono);
    font-size: 11px;
    color: var(--accent);
    letter-spacing: 0.06em;
    margin-bottom: 24px;
    opacity: 0.8;
}

.skill-rows { display: flex; flex-direction: column; gap: 18px; }

.skill-row {}
.skill-meta {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 7px;
    flex-wrap: wrap;
}
.skill-name {
    font-family: var(--font-mono);
    font-size: 13px;
    color: #fff;
}
.skill-tags { display: flex; flex-wrap: wrap; gap: 4px; }
.stag {
    font-family: var(--font-mono);
    font-size: 9px;
    color: var(--text-muted);
    border: 1px solid var(--border);
    padding: 1px 6px;
    border-radius: 3px;
}

.bar-track {
    position: relative;
    height: 4px;
    background: var(--bg-elevated);
    border-radius: 2px;
    overflow: visible;
}
.bar-fill {
    height: 100%;
    background: var(--accent);
    border-radius: 2px;
    transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 0 8px rgba(180, 241, 110, 0.3);
}
.bar-pct {
    position: absolute;
    right: 0;
    top: 8px;
    font-family: var(--font-mono);
    font-size: 10px;
    color: var(--text-dim);
}

@media (max-width: 768px) { .skills-content { grid-template-columns: 1fr; } }
</style>
