<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Create some team members
        $members = [
            ['name' => 'Alice Martin', 'email' => 'alice@test.com'],
            ['name' => 'Jean Dupont', 'email' => 'jean@test.com'],
            ['name' => 'Sophie Bernard', 'email' => 'sophie@test.com'],
            ['name' => 'Thomas Petit', 'email' => 'thomas@test.com'],
        ];

        $userModels = [];
        foreach ($members as $m) {
            // Check if user already exists
            $user = User::where('email', $m['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $m['name'],
                    'email' => $m['email'],
                    'password' => Hash::make('password123'),
                    'role' => 'member',
                ]);
            }
            $userModels[] = $user;
        }

        // Get the main admin
        $admin = User::where('role', 'admin')->first() ?: User::first();

        // 2. Create Projects
        $projects = [
            [
                'name' => 'Refonte du site web',
                'description' => 'Modernisation complète de la plateforme e-commerce avec intégration de nouveaux modes de paiement.',
                'status' => 'in_progress',
                'due_date' => now()->addMonths(3),
            ],
            [
                'name' => 'Application Mobile de Livraison',
                'description' => 'Développement d\'une application iOS et Android pour la gestion des livraisons en temps réel.',
                'status' => 'in_progress',
                'due_date' => now()->addMonths(2),
            ],
            [
                'name' => 'Gestion des Étudiants',
                'description' => 'Système interne pour le suivi des notes, des absences et des inscriptions aux cours.',
                'status' => 'in_progress',
                'due_date' => now()->addMonth(),
            ],
        ];

        foreach ($projects as $pData) {
            $project = Project::create(array_merge($pData, ['user_id' => $admin->id]));

            // Add members to project
            $project->members()->syncWithoutDetaching([
                $userModels[0]->id => ['role' => 'developer'],
                $userModels[1]->id => ['role' => 'designer']
            ]);

            // 3. Create Tasks for each project
            $taskData = [
                ['title' => 'Concevoir la maquette de la page d\'accueil', 'status' => 'done'],
                ['title' => 'Mettre à jour la base de données', 'status' => 'in_progress'],
                ['title' => 'Intégrer Google Maps', 'status' => 'done'],
                ['title' => 'Créer l\'écran de connexion', 'status' => 'done'],
                ['title' => 'Ajouter les notifications push', 'status' => 'done'],
                ['title' => 'Générer les bulletins PDF', 'status' => 'todo'],
                ['title' => 'Ajouter la recherche avancée', 'status' => 'todo'],
            ];

            foreach ($taskData as $index => $t) {
                $task = Task::create([
                    'title' => $t['title'],
                    'description' => 'Détails de la tâche pour le projet ' . $project->name,
                    'status' => $t['status'],
                    'project_id' => $project->id,
                    'user_id' => $userModels[$index % count($userModels)]->id,
                    'due_date' => now()->addDays(rand(1, 30)),
                ]);

                // 4. Add some comments
                if ($index % 2 == 0) {
                    Comment::create([
                        'content' => 'Excellent travail sur cette partie !',
                        'task_id' => $task->id,
                        'user_id' => $admin->id,
                    ]);
                }
            }
        }
    }
}
