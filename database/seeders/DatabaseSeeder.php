<?php

namespace Database\Seeders;

use App\Models\Moment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Admin credentials are set via env:
     *   ADMIN_EMAIL    (default: jordan@jordanholton.com)
     *   ADMIN_PASSWORD (default: changeme — change this!)
     */
    public function run(): void
    {
        // ── Admin user ────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'jordan@jordanholton.com')],
            [
                'name'     => env('ADMIN_NAME', 'Jordan Holton'),
                'email'    => env('ADMIN_EMAIL', 'jordan@jordanholton.com'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'changeme')),
            ]
        );

        // ── Sample moments ────────────────────────────────────────────
        $moments = [
            [
                'title'     => 'Launched this site',
                'date'      => '2026-05-26',
                'body'      => 'Finally shipped the personal site I\'ve been putting off for years. Built with Laravel, Inertia.js, and Vue 3. Simple, fast, and mine.',
                'category'  => 'milestone',
                'published' => true,
            ],
            [
                'title'     => 'Passed the CKA exam',
                'date'      => '2025-11-03',
                'body'      => 'Certified Kubernetes Administrator — done. Months of cluster work, ETCD backups, and network policy debugging finally paid off.',
                'category'  => 'professional',
                'published' => true,
            ],
            [
                'title'     => 'First 50K trail run',
                'date'      => '2025-06-14',
                'body'      => 'Finished my first 50K trail run. 5h 42m. More mud than expected, more joy than I thought possible. Already thinking about what\'s next.',
                'category'  => 'personal',
                'published' => true,
            ],
            [
                'title'     => 'Started a new role',
                'date'      => '2025-01-06',
                'body'      => 'Joined a new team as Lead Systems Architect. Day one: designing distributed data pipelines at a scale I\'ve only read about. Excited.',
                'category'  => 'professional',
                'published' => true,
            ],
            [
                'title'     => 'Open-sourced my Terraform modules',
                'date'      => '2024-08-19',
                'body'      => 'Published a collection of production-tested Terraform modules for AWS — VPC, ECS, and RDS with sensible defaults and full documentation.',
                'category'  => 'milestone',
                'published' => true,
            ],
        ];

        foreach ($moments as $data) {
            Moment::firstOrCreate(['title' => $data['title'], 'date' => $data['date']], $data);
        }
    }
}
