<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;

use App\Models\User;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('manager');

        if (auth()->check() && auth()->user()->role !== 'admin') {
            $query->where(function ($q) {
                $q->where('user_id', auth()->id())
                  ->orWhereHas('members', function ($q2) {
                      $q2->where('users.id', auth()->id());
                  })
                  ->orWhereHas('tasks', function ($q3) {
                      $q3->where('user_id', auth()->id());
                  });
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $projects = $query->paginate(10)->withQueryString();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|string|max:255',
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? 'pending',
            'due_date' => $validated['due_date'] ?? null,
            'user_id' => auth()->id(),
        ]);

        if (isset($validated['members']) && count($validated['members']) > 0) {
            $syncData = [];
            foreach ($validated['members'] as $index => $userId) {
                if (!empty($userId)) {
                    $role = !empty($validated['roles'][$index]) ? $validated['roles'][$index] : 'member';
                    $syncData[$userId] = ['role' => $role];
                }
            }
            $project->members()->sync($syncData);
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            $project->load(['tasks' => function ($query) {
                $query->where('user_id', auth()->id())->with('assignee');
            }, 'sprints']);
        } else {
            $project->load('tasks.assignee', 'sprints');
        }
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('projects.index')->with('error', 'Unauthorized action. Only admins can delete projects.');
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
