<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $member = \App\Models\User::create([
            'name' => 'Member User',
            'email' => 'member@test.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        $project = \App\Models\Project::create([
            'name' => 'First Project',
            'description' => 'This is a test project',
            'user_id' => $admin->id,
        ]);

        $sprint = \App\Models\Sprint::create([
            'name' => 'Sprint 1',
            'start_date' => now(),
            'end_date' => now()->addDays(14),
            'project_id' => $project->id,
        ]);

        $task = \App\Models\Task::create([
            'title' => 'First Task',
            'description' => 'This is a test task',
            'status' => 'todo',
            'project_id' => $project->id,
            'sprint_id' => $sprint->id,
            'user_id' => $member->id,
        ]);

        \App\Models\Comment::create([
            'content' => 'This is a test comment',
            'task_id' => $task->id,
            'user_id' => $admin->id,
        ]);
    }
}
