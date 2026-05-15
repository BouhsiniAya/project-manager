<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Notifications\TaskReminder;
use App\Notifications\ProjectReminder;
use Carbon\Carbon;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send due date reminders for tasks and projects';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        // 1. Task Reminders
        $tasks = Task::where('due_date', $tomorrow)
            ->where('status', '!=', 'done')
            ->whereNotNull('user_id')
            ->get();

        $taskCount = 0;
        foreach ($tasks as $task) {
            $user = User::find($task->user_id);
            if ($user) {
                $user->notify(new TaskReminder($task));
                $taskCount++;
            }
        }
        $this->info("Sent {$taskCount} task reminders.");

        // 2. Project Reminders
        $projects = Project::where('due_date', $tomorrow)
            ->where('status', '!=', 'completed')
            ->whereNotNull('user_id')
            ->get();

        $projectCount = 0;
        foreach ($projects as $project) {
            $manager = User::find($project->user_id);
            if ($manager) {
                $manager->notify(new ProjectReminder($project));
                $projectCount++;
            }
        }
        $this->info("Sent {$projectCount} project reminders.");

        return 0;
    }
}
