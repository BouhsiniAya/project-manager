<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class GhizlaneProjectsSeeder extends Seeder
{
    public function run()
    {
        $ghizlane = User::where('name', 'like', '%Ghizlane%')->first();

        if (!$ghizlane) {
            return;
        }

        $projects = [
            [
                'name' => 'Campagne Marketing Hiver',
                'description' => 'Planification et exécution de la campagne publicitaire pour la saison d\'hiver.',
                'status' => 'in_progress',
                'due_date' => now()->addMonths(2),
            ],
            [
                'name' => 'Audit Sécurité 2026',
                'description' => 'Vérification complète des protocoles de sécurité réseau et conformité RGPD.',
                'status' => 'pending',
                'due_date' => now()->addMonth(),
            ],
        ];

        foreach ($projects as $pData) {
            $project = Project::create(array_merge($pData, ['user_id' => $ghizlane->id]));

            // Add some tasks
            Task::create([
                'title' => 'Analyse des mots-clés',
                'description' => 'Recherche SEO pour les produits phares.',
                'status' => 'in_progress',
                'project_id' => $project->id,
                'user_id' => $ghizlane->id,
            ]);

            Task::create([
                'title' => 'Configuration du Firewall',
                'description' => 'Mise à jour des règles de filtrage.',
                'status' => 'todo',
                'project_id' => $project->id,
                'user_id' => $ghizlane->id,
            ]);
        }
    }
}
